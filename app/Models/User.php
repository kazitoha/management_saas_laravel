<?php

namespace App\Models;

use App\Models\Companies;
use App\Traits\LogsActivity;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'companies_id',
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_users')->withTimestamps();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Companies::class, 'companies_id');
    }



    /**
     * Get the projects for the user.
     */
    public function projects()
    {
        return $this->hasMany(Projects::class);
    }

    /**
     * Get the tasks for the user.
     */
    public function tasks()
    {
        return $this->hasMany(Tasks::class);
    }

    /**
     * Get the routines for the user.
     */
    public function routines()
    {
        return $this->hasMany(Routines::class);
    }

    /**
     * Get the notes for the user.
     */
    public function notes()
    {
        return $this->hasMany(Notes::class);
    }

    /**
     * Get the calendar events for the user.
     */
    public function files()
    {
        return $this->hasMany(Files::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminders::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequests::class);
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalances::class);
    }

    public function projectMembers()
    {
        return $this->belongsToMany(Projects::class, 'project_teams', 'user_id', 'project_id');
    }


    public function hasRole(string $role): bool
    {
        return $this->role && $this->role->name === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->role && in_array($this->role->name, $roles, true);
    }


    public function conveyanceBills()
    {
        return $this->hasMany(ConvenyanceBills::class);
    }
}
