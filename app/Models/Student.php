<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['device_user_id','name','father_name','department','phone_number','email'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id', 'id');
    }
}
