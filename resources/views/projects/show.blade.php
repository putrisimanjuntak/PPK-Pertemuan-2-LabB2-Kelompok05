@extends('layouts.app')
@section('content')

<div class="card">
    <h1>{{ $project->name }}</h1>
    <p>{{ $project->description }}</p>
    <a class="btn" href="{{ route('tasks.create', $project) }}">+ Tugas</a>
    <a class="btn" href="{{ route('projects.edit', $project) }}">Edit</a>
    <form class="inline" method="POST" action="{{ route('projects.destroy', $project) }}">
        @csrf @method('DELETE')
        <button class="danger" onclick="return confirm('Hapus project?')">Hapus</button>
    </form>
</div>

{{-- ===================================================================
     SRS-009: Pemantauan progres penyelesaian tugas dalam proyek
     - Jumlah tugas selesai & belum selesai ditampilkan berdampingan.
     - Progres ditampilkan sebagai persentase + progress bar.
     - Karena nilainya dihitung ulang di ProjectController@show, tampilan
       ini otomatis ter-update begitu ada tugas yang ditandai selesai.
=================================================================== --}}
<div class="card">
    <h2>Progres Penyelesaian Tugas</h2>
    <p>
        <span class="badge">Selesai: {{ $tasksDone }}</span>
        <span class="badge">Belum selesai: {{ $tasksRemaining }}</span>
        <span class="badge">Total: {{ $tasksTotal }}</span>
    </p>
    <div style="background:#e5e7eb;border-radius:6px;overflow:hidden;height:14px;width:100%">
        <div style="background:#22c55e;height:100%;width:{{ $progressPercentage }}%"></div>
    </div>
    <p class="muted">{{ $progressPercentage }}% selesai</p>
</div>

<div class="card">
    <h2>Tugas</h2>
    @forelse($project->tasks as $t)
        <p>
            <a href="{{ route('tasks.show', $t) }}">{{ $t->title }}</a>
            <span class="badge">{{ $t->status }}</span>
        </p>
    @empty
        <p>Belum ada tugas.</p>
    @endforelse
</div>

@endsection
