<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'name',
        'ip_address',
        'port',
        'comm_key',
        'is_active'
    ];
}
