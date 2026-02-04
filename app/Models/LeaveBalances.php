<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;

class LeaveBalances extends Model
{
    use CompanyScoped, LogsActivity;

    //
}
