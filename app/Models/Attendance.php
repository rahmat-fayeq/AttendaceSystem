<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'device_id',
        'uid',
        'user_id',
        'student_id',
        'state',
        'record_time',
        'type',
    ];

    protected $casts = [
        'record_time' => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
