<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // SRS-002: pembedaan peran admin vs user
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // SRS-006: tugas kolaboratif tempat user ini menjadi anggota
    public function collaboratingTasks()
    {
        return $this->belongsToMany(Task::class, 'task_members', 'user_id', 'task_id')
            ->withPivot(['member_status', 'joined_at'])
            ->withTimestamps();
    }

    public function taskMemberships()
    {
        return $this->hasMany(TaskMember::class);
    }
}
