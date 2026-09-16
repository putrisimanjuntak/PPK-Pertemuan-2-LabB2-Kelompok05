@extends('layouts.app')
@section('content')

<div style="display:flex;justify-content:space-between">
    <h1>Project</h1>
    <a class="btn" href="{{ route('projects.create') }}">+ Project Baru</a>
</div>

<div class="grid">
    @forelse($projects as $p)
        <div class="card">
            <h2>{{ $p->name }}</h2>
            <p class="muted">{{ $p->description }}</p>
            <p>{{ $p->tasks_count }} tugas</p>

            {{-- SRS-009: indikator ringkas progres tiap proyek pada daftar
                 project, agar progres bisa dipantau tanpa membuka detail. --}}
            <div style="background:#e5e7eb;border-radius:6px;overflow:hidden;height:8px;width:100%">
                <div style="background:#22c55e;height:100%;width:{{ $p->progressPercentage() }}%"></div>
            </div>
            <p class="muted">{{ $p->progressPercentage() }}% selesai ({{ $p->tasksDoneCount() }}/{{ $p->tasksTotalCount() }})</p>

            <a class="btn" href="{{ route('projects.show', $p) }}">Buka</a>
        </div>
    @empty
        <div class="card">Belum ada project.</div>
    @endforelse
</div>

@endsection
