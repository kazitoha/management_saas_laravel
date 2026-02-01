<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Projects;

class Clients extends Model
{
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
