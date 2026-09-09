{{-- SRS-006: Sertakan partial ini di halaman detail tugas: @include('tasks.members', ['task' => $task]) --}}
<div>
    <h3>Kolaborator Tugas</h3>

    @if (session('status'))
        <p style="color:green">{{ session('status') }}</p>
    @endif
    @if ($errors->any())
        <div style="color:red">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <ul>
        @forelse ($task->members as $member)
            <li>
                {{ $member->user->name }} ({{ $member->user->email }})
                — status: <strong>{{ $member->member_status }}</strong>

                @if ($task->user_id === auth()->id())
                    <form method="POST" action="{{ route('tasks.members.destroy', [$task, $member]) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                @endif

                @if ($member->user_id === auth()->id() && $member->member_status === 'pending')
                    <form method="POST" action="{{ route('tasks.members.respond', [$task, $member]) }}" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="member_status" value="accepted">
                        <button type="submit">Terima</button>
                    </form>
                    <form method="POST" action="{{ route('tasks.members.respond', [$task, $member]) }}" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="member_status" value="rejected">
                        <button type="submit">Tolak</button>
                    </form>
                @endif
            </li>
        @empty
            <li>Belum ada kolaborator.</li>
        @endforelse
    </ul>

    @if ($task->user_id === auth()->id())
        <h4>Tambah Kolaborator</h4>
        <form method="POST" action="{{ route('tasks.members.store', $task) }}">
            @csrf
            <input type="email" name="email" placeholder="Email pengguna" required>
            <button type="submit">Tambah</button>
        </form>
    @endif
</div>
