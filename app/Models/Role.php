<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use  LogsActivity;

    protected $table = 'roles';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_users')->withTimestamps();
    }
}
