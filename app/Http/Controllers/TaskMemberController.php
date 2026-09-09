<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskMember;
use App\Models\User;
use Illuminate\Http\Request;

// SRS-006: Kolaborasi — pemilik tugas menambahkan pengguna lain & memantau progres
class TaskMemberController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $this->authorizeOwner($task);

        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Pengguna dengan email tersebut tidak ditemukan.',
        ]);

        $collaborator = User::where('email', $data['email'])->firstOrFail();

        if ($collaborator->id === $task->user_id) {
            return back()->withErrors(['email' => 'Pemilik tugas tidak perlu ditambahkan sebagai kolaborator.']);
        }

        // Duplikat kolaborator tidak bisa ditambahkan
        $alreadyMember = TaskMember::where('task_id', $task->id)
            ->where('user_id', $collaborator->id)
            ->exists();

        if ($alreadyMember) {
            return back()->withErrors(['email' => 'Pengguna ini sudah menjadi kolaborator pada tugas ini.']);
        }

        TaskMember::create([
            'task_id' => $task->id,
            'user_id' => $collaborator->id,
            'member_status' => 'pending',
        ]);

        return back()->with('status', 'Kolaborator berhasil ditambahkan.');
    }

    // Kolaborator menerima/menolak undangan -> memengaruhi status per kolaborator
    public function respond(Request $request, Task $task, TaskMember $member)
    {
        abort_unless($member->user_id === auth()->id(), 403);
        abort_unless($member->task_id === $task->id, 404);

        $data = $request->validate([
            'member_status' => ['required', 'in:accepted,rejected'],
        ]);

        $member->update([
            'member_status' => $data['member_status'],
            'joined_at' => $data['member_status'] === 'accepted' ? now() : null,
        ]);

        return back()->with('status', 'Status kolaborasi diperbarui.');
    }

    // Hanya pemilik tugas yang dapat menghapus kolaborator
    public function destroy(Task $task, TaskMember $member)
    {
        $this->authorizeOwner($task);
        abort_unless($member->task_id === $task->id, 404);

        $member->delete();

        return back()->with('status', 'Kolaborator berhasil dihapus.');
    }

    private function authorizeOwner(Task $task): void
    {
        abort_unless(
            $task->user_id === auth()->id(),
            403,
            'Hanya pemilik tugas yang dapat mengelola kolaborator.'
        );
    }
}
