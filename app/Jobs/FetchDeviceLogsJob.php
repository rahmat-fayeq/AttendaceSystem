<?php

namespace App\Jobs;

use App\Models\Device;
use App\Models\Attendance;
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

        // Attempt to fetch logs
        $logs = $device->fetchAttendanceLogs();

        if ($logs === false) {
            Log::warning("Unable to connect to device: {$device->name} ({$device->ip_address})");
            return;
        }

        Log::info("Connected to device: {$device->name} | Logs fetched: " . count($logs));

        foreach ($logs as $log) {
            Attendance::updateOrCreate(
                ['uid' => $log['uid']],
                [
                    'device_id'   => $device->id,
                    'user_id'     => $log['user_id'],
                    'state'       => $log['state'],
                    'record_time' => $log['record_time'],
                    'type'        => $log['type'],
                ]
            );
        }

        Log::info("Logs stored for device: {$device->name}");
    }
}
