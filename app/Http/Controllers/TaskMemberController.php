<?php

namespace App\Http\Controllers;

use App\Models\{Task, TaskMember};
use Illuminate\Http\Request;

/**
 * SRS-008: Penugasan tugas kepada lebih dari satu anggota tim.
 *
 * Satu Task dapat memiliki banyak baris TaskMember (relasi hasMany di
 * App\Models\Task::members()), sehingga satu tugas bisa ditugaskan ke
 * lebih dari satu anggota sekaligus.
 */
class TaskMemberController extends Controller
{
    /** Hanya pemilik tugas yang boleh menambah/menghapus anggota. */
    private function own(Task $t)
    {
        abort_unless($t->user_id === auth()->id(), 403);
    }

    /**
     * SRS-008: menambahkan (menugaskan) seorang anggota ke sebuah tugas.
     *
     * - "Pemilik tugas dapat menugaskan satu tugas kepada lebih dari satu
     *   anggota tim": endpoint ini bisa dipanggil berulang kali untuk
     *   user_id yang berbeda pada task yang sama.
     * - "Satu pengguna tidak dapat ditambahkan lebih dari satu kali pada
     *   tugas yang sama": dijamin oleh updateOrCreate() yang mencocokkan
     *   pasangan (task_id, user_id) — jika sudah ada, statusnya di-update,
     *   bukan membuat baris duplikat. Constraint ini juga dikunci di level
     *   database lewat unique(['task_id','user_id']) pada migration
     *   task_members (lihat database/migrations/..._create_task_members_table.php).
     */
    public function store(Request $r, Task $task)
    {
        $this->own($task);

        $d = $r->validate([
            'user_id' => 'required|exists:users,id',
            'member_status' => 'required|in:pending,accepted,rejected',
        ]);

        TaskMember::updateOrCreate(
            ['task_id' => $task->id, 'user_id' => $d['user_id']],
            ['member_status' => $d['member_status'], 'joined_at' => now()]
        );

        return back()->with('success', 'Anggota ditambahkan.');
    }

    /** SRS-008: melepas penugasan seorang anggota dari sebuah tugas. */
    public function destroy(Task $task, $userId)
    {
        $this->own($task);
        TaskMember::where('task_id', $task->id)->where('user_id', $userId)->delete();

        return back()->with('success', 'Anggota dihapus.');
    }
}
