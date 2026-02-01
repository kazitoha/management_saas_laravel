<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Projects;
use App\Models\TaskCheckListItem;
use App\Models\User;

class Tasks extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'project_id',
        'assigned_to',
        'created_by',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'projects_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function checklistItems()
    {
        return $this->hasMany(TaskCheckListItem::class, 'task_id');
    }
}
