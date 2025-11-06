<?php

namespace App\Jobs;

use App\Models\Device;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchDeviceLogsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $device;

    /**
     * Create a new job instance.
     */
    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    /**
     * Execute the job.
     */
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

        foreach ($logs as $log) {
            $recordTime = Carbon::parse($log['record_time']);
            $recordDate = $recordTime->toDateString();

            $exists = Attendance::where('user_id', $log['user_id'])
                ->where('device_id', $device->id)
                ->whereDate('record_time', $recordDate)
                ->whereBetween('record_time', [
                    $recordTime->copy()->subHours(3),
                    $recordTime->copy()->subHours(3),
                ])
                ->exists();

            if ($exists) {
                $skipped++;
                Log::info("Skipping duplicate punch for UID {$log['user_id']} around {$recordTime}");
                continue;
            }

            Attendance::create([
                'device_id'   => $device->id,
                'uid'         => $log['uid'],
                'user_id'     => $log['user_id'],
                'student_id'  => $log['student_id'] ?? null,
                'state'       => $log['state'],
                'record_time' => $log['record_time'],
                'type'        => $log['type'],
            ]);

            $processed++;
        }

        Log::info("Logs stored for device: {$device->name} | Processed: {$processed}, Skipped: {$skipped}");
    }
}
