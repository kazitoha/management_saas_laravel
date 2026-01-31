<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockIP extends Model
{
    protected $table = 'blocked_ips';

    protected $fillable = [
        'ip_address',
        'blocked_at',
        'reason',
    ];

    protected $casts = [
        'blocked_at' => 'datetime',
    ];
}
