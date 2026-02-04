<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;

class Reminders extends Model
{
    use CompanyScoped, LogsActivity;

    protected $table = 'reminders';
    protected $fillable = [
        'title',
        'description',
        'reminder_date',
        'company_id',
    ];
    //
}
