{{-- SRS-007: Panel admin — daftar akun pengguna (tambah & hapus akun). --}}
@extends('layouts.app')
@section('content')

<div style="display:flex;justify-content:space-between">
    <h1>Manajemen User</h1>
    <a class="btn" href="{{ route('admin.users.create') }}">+ User</a>
</div>

<div class="card">
    <table>
        <tr><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr>
        @foreach($users as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    <a class="btn" href="{{ route('admin.users.edit', $u) }}">Edit</a>
                    {{-- SRS-007: tombol hapus akun. --}}
                    <form class="inline" method="POST" action="{{ route('admin.users.destroy', $u) }}">
                        @csrf @method('DELETE')
                        <button class="danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>

@endsection
