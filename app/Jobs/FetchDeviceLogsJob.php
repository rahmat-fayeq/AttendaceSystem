<?php

namespace App\Jobs;

use App\Models\Device;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class FetchDeviceLogsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $device;
    public $tries = 3;
    public $retryAfter = 60;

    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    public function handle(): void
    {
        $device = $this->device;
        $logs = $device->fetchAttendanceLogs();

        if ($logs === false || empty($logs)) {
            Log::warning("No logs fetched from device: {$device->name}");
            return;
        }

        $processed = 0;
        $skipped = 0;
        $notificationJobs = []; 

        foreach ($logs as $log) {
            $recordTime = Carbon::parse($log['record_time']);
            $recordDate = $recordTime->toDateString();

            // Avoid duplicates of the same type within 3 hours
            $exists = Attendance::where('user_id', $log['user_id'])
                ->where('device_id', $device->id)
                ->where('type', $log['type'])
                ->whereBetween('record_time', [
                    $recordTime->copy()->subHours(3),
                    $recordTime->copy()->addHours(3),
                ])
                ->exists();

            if ($exists) {
                $skipped++;
                Log::info("Skipping duplicate punch for UID {$log['user_id']} around {$recordTime}");
                continue;
            }

            $attendance = Attendance::create([
                'device_id'   => $device->id,
                'uid'         => $log['uid'],
                'user_id'     => $log['user_id'],
                'student_id'  => $log['student_id'] ?? null,
                'state'       => $log['state'],
                'record_time' => $log['record_time'],
                'type'        => $log['type'],
            ]);

            // Send notifications if student found
            if ($attendance->student_id) {
                $student = Student::find($attendance->student_id);

                if ($student) {
                    $message = "Dear {$student->name}, your attendance was recorded at {$attendance->record_time}.";

                    // Queue SMS
                    if (!empty($student->phone_number)) {
                        $notificationJobs[] = new SendSmsJob($student->phone_number, $message);
                    }

                    // Queue Email
                    if (!empty($student->email)) {
                         $notificationJobs[] = new SendEmailJob($student, $attendance);
                    }
                }
            }

            $processed++;
        }

        // Dispatch batch of notification jobs
        if (!empty($notificationJobs)) {
            $batch = Bus::batch($notificationJobs)
                ->name('Attendance Notifications Batch')
                ->allowFailures()
                ->then(function ($batch) {
                    Log::info("✅ Notification batch completed: Total={$batch->totalJobs}, Failed={$batch->failedJobs}");
                })
                ->catch(function ($batch, $e) {
                    Log::error("❌ Notification batch failed: " . $e->getMessage());
                })
                ->finally(function ($batch) {
                    Log::info("⚙️ Notification batch finalized (ID: {$batch->id})");
                })
                ->dispatch();

            Log::info("🚀 Notification batch dispatched with {$batch->totalJobs} jobs.");
        }

        Log::info("Logs stored for device: {$device->name} | Processed: {$processed}, Skipped: {$skipped}");
    }
}
