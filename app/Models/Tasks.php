<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Projects;
use App\Models\TaskCheckListItem;
use App\Models\User;
use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;

class Tasks extends Model
{
    use CompanyScoped, LogsActivity;

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
        'company_id',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
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
