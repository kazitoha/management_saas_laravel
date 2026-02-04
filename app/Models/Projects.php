<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use LogsActivity;

    protected $table = 'projects';

    protected $fillable = [
        'company_id',
        'user_id',
        'client_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'budget',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'project_id');
    }
    public function teams()
    {
        return $this->belongsToMany(User::class, 'project_teams', 'project_id', 'user_id');
    }


    public function files()
    {
        return $this->hasMany(Files::class);
    }

    // Computed status based on dates/tasks, kept separate from stored 'status' column
    public function getComputedStatusAttribute()
    {
        $today = Carbon::now();

        if ($this->start_date && $today->lt($this->start_date)) {
            return 'pending';
        }

        if ($this->end_date && $this->end_date->lt($today)) {
            $unfinishedTasks = $this->tasks()->where('status', '!=', 'completed')->count();
            return $unfinishedTasks > 0 ? 'unfinished' : 'finished';
        }

        return 'on_going';
    }

    public function teamProjects()
    {
        return $this->belongsToMany(ProjectTeams::class, 'project_teams', 'project_id', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_teams', 'project_id', 'user_id');
    }
}
