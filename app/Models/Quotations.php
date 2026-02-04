<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;

class Quotations extends Model
{
    use CompanyScoped, LogsActivity;

    //
}
