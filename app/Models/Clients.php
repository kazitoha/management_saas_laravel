<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Projects;
use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;

class Clients extends Model
{
    use CompanyScoped, LogsActivity;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'address',
        'note',
        'company_id',
    ];

    public function projects()
    {
        return $this->hasMany(Projects::class, 'client_id');
    }
}
