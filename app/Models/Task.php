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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * SRS-008: relasi hasMany ke TaskMember. Karena satu Task boleh
     * memiliki banyak baris TaskMember, satu tugas dapat ditugaskan
     * kepada lebih dari satu anggota tim, dan daftar anggota yang
     * ditugaskan ditampilkan lewat relasi ini (lihat tasks/show.blade.php).
     */
    public function members()
    {
        return $this->hasMany(TaskMember::class);
    }

    /**
     * SRS-009: menandai tugas selesai. Perubahan status ke 'done' inilah
     * yang membuat progres proyek (App\Models\Project::progressPercentage)
     * ikut ter-update, karena progres selalu dihitung ulang dari status
     * tugas saat ini.
     */
    public function markAsDone(): void
    {
        $this->update(['status' => 'done', 'completed_at' => now()]);
    }
}
