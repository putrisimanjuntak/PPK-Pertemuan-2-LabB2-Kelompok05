<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARA Advance To-Do List - Programmer 1</title>
    <!-- Tailwind CSS untuk Page Structure -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="container mx-auto max-w-2xl mt-10 p-6 bg-white rounded-lg shadow-md">
        <!-- Header Struktur Halaman -->
        <h1 class="text-2xl font-bold mb-2 text-gray-800">ARA Advance To-Do List</h1>
        <p class="text-sm text-gray-500 mb-6">Modul Manajemen Tugas & Fitur Utama Programmer 1</p>

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Menampilkan Error Validasi Real-time -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md text-sm font-medium">
                <p>Terjadi kesalahan pengisian:</p>
                <ul class="list-disc pl-5 mt-1 font-normal">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Pembuatan Tugas & Dropdown Prodi -->
        <form action="{{ route('todo.store') }}" method="POST" class="mb-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Judul Tugas</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan nama tugas..." 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Fitur Dropdown Prodi / Kelompok Proyek -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Kelompok Proyek / Prodi</label>
                <select name="project" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 bg-white" required>
                    <option value="">-- Pilih Kategori Proyek --</option>
                    <option value="Informatika">Informatika</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Riset & Tugas Akhir">Riset & Tugas Akhir</option>
                    <option value="Organisasi HMIF">Organisasi HMIF</option>
                </select>
            </div>

            <input type="hidden" name="status" value="pending">

            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition font-medium">
                Simpan Tugas Baru
            </button>
        </form>

        <hr class="my-6">

        <!-- Fitur Pemfilteran Status Tugas -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Daftar Tugas</h2>
            <div class="space-x-2 text-sm">
                <a href="{{ route('todo.index') }}" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Semua</a>
                <a href="{{ route('todo.index', ['status' => 'pending']) }}" class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200">Pending</a>
                <a href="{{ route('todo.index', ['status' => 'completed']) }}" class="px-3 py-1 bg-green-100 text-green-800 rounded hover:bg-green-200">Selesai</a>
            </div>
        </div>

        <!-- List Data Dummy -->
        <div class="space-y-3">
            <div class="p-4 border rounded-md flex justify-between items-center bg-gray-50 shadow-sm">
                <div>
                    <h3 class="font-medium text-gray-800">Contoh Data Tugas Aktif</h3>
                    <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full font-semibold">Informatika</span>
                </div>
                <span class="text-xs font-semibold text-yellow-600 bg-yellow-50 px-2 py-1 rounded border border-yellow-200">Pending</span>
            </div>
        </div>
    </div>

</body>
</html>