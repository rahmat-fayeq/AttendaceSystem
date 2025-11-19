<?php

namespace App\Models;

use CodingLibs\ZktecoPhp\Libs\ZKTeco;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Device extends Model
{
    protected $fillable = [
        'name', 'ip_address', 'port', 'comm_key', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getIsConnectedAttribute(): bool
    {
        return cache()->remember("device_conn_{$this->id}", 60, function () {
            if (!$this->is_active){
                return false;
            }   
            try {
                $zk = new ZKTeco($this->ip_address, $this->port ?? 4370, false, 25, $this->comm_key ?? 0);
                if ($zk->connect()) {
                    $zk->disconnect();
                    return true;
                }
                return false;
            } catch (\Throwable $e) {
                Log::warning("ZKTeco connection check failed for device {$this->name}: " . $e->getMessage());
                return false;
            }
        });
    }

    public function fetchAttendanceLogs()
    {
         if (!$this->is_active || !$this->is_connected) {
            return false;
        }

        try {
            $zk = new ZKTeco($this->ip_address, $this->port ?? 4370, false, 25, $this->comm_key ?? 0);
            if (!$zk->connect()) return false;

            $logs = $zk->getAttendances();
            $zk->disconnect();

            if (!$logs) return [];

            // Map device user_id to student_id
            foreach ($logs as &$log) {
                $student = Student::where('device_user_id', $log['user_id'])->first();
                $log['student_id'] = $student ? $student->id : null;
            }

            return $logs;

        } catch (\Throwable $e) {
            Log::error("ZKTeco connection failed for device {$this->name}: " . $e->getMessage());
            return false;
        }
    }
}
