<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * SRS-007: Panel admin — tambah & hapus akun pengguna dalam sistem.
 *
 * Seluruh method di controller ini hanya dapat dipanggil setelah lolos
 * middleware `isAdmin` (lihat routes/web.php & App\Http\Middleware\IsAdmin),
 * sehingga kriteria "Panel admin hanya bisa diakses saat role = admin"
 * terpenuhi di level route, bukan di controller ini.
 */
class UserManagementController extends Controller
{
    /** SRS-007: menampilkan daftar seluruh akun pengguna. */
    public function index()
    {
        return view('admin.users.index', ['users' => User::latest()->get()]);
    }

    /** SRS-007: menampilkan form tambah akun. */
    public function create()
    {
        return view('admin.users.create', ['user' => new User]);
    }

    /**
     * SRS-007: menyimpan akun baru.
     * Kriteria "Form tambah akun memvalidasi username unik" diterapkan
     * lewat rule `unique:users` pada kolom email (dipakai sebagai
     * identitas login/username pada sistem ini).
     */
    public function store(Request $r)
    {
        $d = $r->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:150|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);
        $d['password'] = Hash::make($d['password']);
        User::create($d);

        return redirect()->route('admin.users.index')->with('success', 'User dibuat.');
    }

    /** SRS-007: menampilkan form edit akun (memakai view yang sama dengan create). */
    public function edit(User $user)
    {
        return view('admin.users.create', compact('user'));
    }

    /**
     * SRS-007: memperbarui akun. Validasi unique email mengecualikan
     * akun yang sedang diedit (`unique:users,email,{id}`).
     */
    public function update(Request $r, User $user)
    {
        $d = $r->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:150|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        if (empty($d['password'])) {
            unset($d['password']);
        } else {
            $d['password'] = Hash::make($d['password']);
        }

        $user->update($d);

        return redirect()->route('admin.users.index')->with('success', 'User diperbarui.');
    }

    /**
     * SRS-007: menghapus akun dari sistem (tabel users).
     * - "Tombol hapus menghapus akun dari localStorage" pada versi awal SRS
     *   kini diimplementasikan sebagai hapus baris di database (`$user->delete()`),
     *   karena aplikasi ini memakai backend Laravel + database, bukan localStorage.
     * - "Akun yang dihapus tidak bisa lagi login" terpenuhi karena setelah
     *   baris user dihapus, proses login (AuthController::login) tidak akan
     *   menemukan kredensial tersebut lagi.
     * - Admin tidak diperbolehkan menghapus akunnya sendiri (abort 422).
     */
    public function destroy(User $user)
    {
        abort_if($user->id === auth()->id(), 422, 'Tidak dapat menghapus akun sendiri.');
        $user->delete();

        return back()->with('success', 'User dihapus.');
    }
}
