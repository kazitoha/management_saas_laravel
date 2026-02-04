<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;

class ProjectTeams extends Model
{
    use CompanyScoped, LogsActivity;

    protected $table = 'project_teams';
    protected $fillable = [
        'project_id',
        'user_id',
        'company_id',
    ];
}
