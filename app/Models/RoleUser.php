<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use LogsActivity;

    protected $table = 'role_users';
}
