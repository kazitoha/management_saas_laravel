<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCheckListItem extends Model
{
    protected $table = 'task_check_list_items';

    protected $fillable = [
        'task_id',
        'title',
        'is_completed',
        'company_id',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    public function task()
    {
        return $this->belongsTo(Tasks::class, 'task_id');
    }
}
