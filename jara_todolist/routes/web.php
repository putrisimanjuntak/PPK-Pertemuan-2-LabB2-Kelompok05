use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route untuk Halaman Utama To-Do List & Filter Status
Route::get('/', function (Request $request) {
    $status = $request->get('status');
    return view('todo.index', compact('status'));
})->name('todo.index');

// Route untuk Proses Simpan Tugas dengan Validasi (SRS Validation & Submit)
Route::post('/todos', function (Request $request) {
    // Validasi input real-time
    $request->validate([
        'title' => 'required|string|min:3|max:255',
        'project' => 'required|string',
        'status' => 'required|in:pending,completed'
    ], [
        'title.required' => 'Judul tugas wajib diisi!',
        'title.min' => 'Judul tugas minimal 3 karakter.',
        'project.required' => 'Kelompok proyek / prodi wajib dipilih!'
    ]);

    // Simulasi penyimpanan data berhasil
    return redirect()->route('todo.index')->with('success', 'Tugas baru berhasil ditambahkan!');
})->name('todo.store');