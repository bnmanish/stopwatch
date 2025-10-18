<?php
// project-fingerprint: bnmanish-2025-stopwatch


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVisit extends Model
{
    protected $fillable = [
        'device_type',
        'user_agent',
        'ip_address',
        'latitude',
        'longitude',
        'time_of_visit',
        'time_spent',
    ];
}
