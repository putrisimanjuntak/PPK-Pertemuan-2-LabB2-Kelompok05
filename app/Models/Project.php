<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['user_id', 'name', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /*
    |--------------------------------------------------------------------
    | SRS-009 — Pemantauan progres penyelesaian tugas dalam daftar/proyek
    |--------------------------------------------------------------------
    | Kriteria terkait:
    | - Menampilkan jumlah tugas selesai & belum selesai dalam proyek.
    | - Menampilkan persentase/indikator progres penyelesaian.
    | - Progres otomatis ikut berubah begitu tugas ditandai selesai,
    |   karena nilainya selalu dihitung ulang (bukan disimpan statis)
    |   dari relasi tasks() setiap kali diakses.
    */

    /** SRS-009: total tugas dalam proyek ini. */
    public function tasksTotalCount(): int
    {
        return $this->tasks()->count();
    }

    /** SRS-009: jumlah tugas yang sudah selesai (status = done). */
    public function tasksDoneCount(): int
    {
        return $this->tasks()->where('status', 'done')->count();
    }

    /** SRS-009: jumlah tugas yang belum selesai (todo + in_progress). */
    public function tasksRemainingCount(): int
    {
        return $this->tasksTotalCount() - $this->tasksDoneCount();
    }

    /** SRS-009: persentase progres penyelesaian (0-100), dibulatkan. */
    public function progressPercentage(): int
    {
        $total = $this->tasksTotalCount();

        if ($total === 0) {
            return 0;
        }

        return (int) round(($this->tasksDoneCount() / $total) * 100);
    }
}
