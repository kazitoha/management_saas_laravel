<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;

class Routines extends Model
{
    use CompanyScoped, LogsActivity;

    protected $table = 'routines';
    protected $fillable = [
        'name',
        'description',
        'frequency',
        'company_id',
    ];

    //
}
