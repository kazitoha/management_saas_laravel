<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CompanyScoped;
use App\Traits\LogsActivity;

class TaskCheckListItem extends Model
{
    use CompanyScoped, LogsActivity;

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
