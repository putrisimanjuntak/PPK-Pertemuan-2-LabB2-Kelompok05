@extends('layouts.app')
@section('content')

<div class="card">
    <h1>{{ $task->title }}</h1>
    <p>{{ $task->description }}</p>
    <p>
        <span class="badge">{{ $task->priority }}</span>
        <span class="badge">{{ $task->status }}</span>
        Deadline: {{ $task->due_date?->format('d-m-Y') ?? '-' }}
    </p>
    <a class="btn" href="{{ route('tasks.edit', $task) }}">Edit</a>
    @if($task->status !== 'done')
        {{-- SRS-009: menandai tugas selesai -> memicu progres proyek terupdate. --}}
        <form class="inline" method="POST" action="{{ route('tasks.done', $task) }}">
            @csrf @method('PATCH')
            <button>Selesaikan</button>
        </form>
    @endif
    <form class="inline" method="POST" action="{{ route('tasks.destroy', $task) }}">
        @csrf @method('DELETE')
        <button class="danger">Hapus</button>
    </form>
</div>

{{-- ===================================================================
     SRS-008: Penugasan tugas kepada lebih dari satu anggota tim.
     - Form di bawah memanggil TaskMemberController@store untuk
       menugaskan (menambah) satu anggota per submit; bisa dipakai
       berulang kali dengan user berbeda agar tugas punya banyak anggota.
     - Daftar @foreach($task->members ...) menampilkan seluruh anggota
       yang sudah ditugaskan pada tugas ini, sesuai kriteria "anggota
       yang ditugaskan dapat melihat tugas" & "daftar anggota ditampilkan".
=================================================================== --}}
<div class="card">
    <h2>Anggota Tugas</h2>
    <form method="POST" action="{{ route('tasks.members.add', $task) }}">
        @csrf
        <select name="user_id" required>
            <option value="">Pilih user</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
            @endforeach
        </select>
        <select name="member_status">
            <option value="pending">pending</option>
            <option value="accepted">accepted</option>
            <option value="rejected">rejected</option>
        </select>
        <button>Tambah Anggota</button>
    </form>

    @foreach($task->members as $m)
        <p>
            {{ $m->user->name }} - <span class="badge">{{ $m->member_status }}</span>
            <form class="inline" method="POST" action="{{ route('tasks.members.remove', [$task, $m->user_id]) }}">
                @csrf @method('DELETE')
                <button class="danger">Hapus</button>
            </form>
        </p>
    @endforeach
</div>

@endsection
