<?php

namespace App\Models;

use CodingLibs\ZktecoPhp\Libs\ZKTeco;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Device extends Model
{
    protected $fillable = [
        'name',
        'ip_address',
        'port',
        'comm_key',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Device has many attendances
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Connect to device and fetch attendance logs.
     * Returns array of logs or false on failure.
     */
    public function fetchAttendanceLogs()
    {
        if (!$this->is_active) {
            return false;
        }

        try {
            $zk = new ZKTeco(
                $this->ip_address,
                $this->port ?? 4370,
                false,
                25,
                $this->comm_key ?? 0
            );

            if ($zk->connect()) {
                $logs = $zk->getAttendances();
                $zk->disconnect();
                return $logs ?: [];
            }

            return false;
        } catch (\Throwable $e) {
            Log::error("ZKTeco connection failed for device {$this->name}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Accessor: Determine if the device is currently connected
     */
    public function getIsConnectedAttribute(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        try {
            $zk = new ZKTeco(
                $this->ip_address,
                $this->port ?? 4370,
                false,
                25,
                $this->comm_key ?? 0
            );

            if ($zk->connect()) {
                $zk->disconnect();
                return true;
            }

            return false;
        } catch (\Throwable $e) {
            Log::warning("ZKTeco connection check failed for device {$this->name}: " . $e->getMessage());
            return false;
        }
    }
}
