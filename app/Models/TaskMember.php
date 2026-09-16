<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * SRS-008: baris pivot penugasan tugas <-> anggota tim.
 * Satu Task boleh punya banyak TaskMember (lihat Task::members()),
 * sehingga satu tugas bisa ditugaskan ke lebih dari satu anggota.
 * Kombinasi (task_id, user_id) bersifat unik (lihat migration
 * create_task_members_table), jadi satu user tidak bisa ditambahkan
 * dua kali pada tugas yang sama.
 */
class TaskMember extends Model
{
    protected $fillable = ['task_id', 'user_id', 'member_status', 'joined_at'];

    protected $casts = ['joined_at' => 'datetime'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
