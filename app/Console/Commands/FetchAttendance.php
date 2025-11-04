<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Device;
use App\Jobs\FetchDeviceLogsJob;

class FetchAttendance extends Command
{
    protected $signature = 'attendance:fetch';
    protected $description = 'Dispatch attendance fetching jobs for all active devices';

    public function handle()
    {
        $devices = Device::where('is_active', true)->get();

        if ($devices->isEmpty()) {
            $this->warn('No active devices found.');
            return 0;
        }

        foreach ($devices as $device) {
            FetchDeviceLogsJob::dispatch($device);
            $this->info("Dispatched fetch job for device: {$device->name}");
        }

        $this->info('All device fetch jobs dispatched.');
        return 0;
    }
}
