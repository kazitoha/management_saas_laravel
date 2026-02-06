<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;


class AttendanceRecord extends Model
{
    use CompanyScoped, LogsActivity;
    protected $table = 'attendance_records';
    protected $fillable = [
        'user_id',
        'check_in_at',
        'check_in_lat',
        'check_in_lng',
        'check_in_address',
        'check_out_at',
        'check_out_lat',
        'check_out_lng',
        'check_out_address',
        'duration_minutes',
        'notes',
    ];
}
