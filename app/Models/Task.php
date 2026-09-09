<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id', 'user_id', 'title', 'description',
        'priority', 'status', 'due_date', 'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function members()
    {
        return $this->hasMany(TaskMember::class);
    }

    // SRS-006: daftar kolaborator (accepted/pending) sebagai model User
    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'task_members', 'task_id', 'user_id')
            ->withPivot(['member_status', 'joined_at'])
            ->withTimestamps();
    }
}
