# ARA Advance To Do

Aplikasi Laravel untuk project dan tugas, dengan Login/Register, Dashboard, CRUD Project, CRUD Task, anggota task, dan manajemen user admin.

## Database
Database mengikuti `database-pbp-pertemuan2.sql` (`jara_todolist`).

## Menjalankan
1. Install dependency: `composer install`
2. Salin `.env.example` menjadi `.env`
3. Atur koneksi MySQL di `.env`
4. Import `database-pbp-pertemuan2.sql` **atau** jalankan `php artisan migrate --seed`.
5. Jalankan `php artisan key:generate`
6. Jalankan `php artisan serve`

Admin hasil seeder: `admin@ara.test` / `password`.

Jika menggunakan Laravel 11/12, daftarkan alias middleware `isAdmin` di `bootstrap/app.php`:
`$middleware->alias(['isAdmin' => \App\Http\Middleware\IsAdmin::class]);`

Catatan: ZIP ini berisi source project. Folder `vendor` tidak disertakan sehingga `composer install` tetap diperlukan.
