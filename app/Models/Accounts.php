<?php

namespace App\Models;

use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;


class Accounts extends Model
{
    use CompanyScoped, LogsActivity;
    //
}
