<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;

class Expenses extends Model
{
    use CompanyScoped, LogsActivity;

    //
}
