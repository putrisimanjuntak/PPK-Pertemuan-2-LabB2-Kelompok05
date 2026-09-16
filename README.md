# PPK-Pertemuan-2-LabB2-Kelompok05

# JARA Advance To Do List

Sistem manajemen tugas berbasis web yang memungkinkan pengguna mengelola tugas pribadi maupun tim, mengelompokkannya ke dalam daftar/proyek, menetapkan prioritas & tenggat waktu, serta berkolaborasi dengan pengguna lain di bawah pengawasan admin.

## User Story

Sebagai pengguna, saya ingin mengelola tugas pribadi maupun tim dalam satu daftar terorganisir dengan prioritas dan tenggat waktu, sehingga saya dapat bekerja lebih terstruktur dan memantau progres bersama tim.

## Daftar SRS

| **Kode**    | **Deskripsi**                                                                              | **Acceptance Criteria**                                                                                                                                                                                                                                                                                              |
| ----------- | ------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **SRS-001** | Struktur halaman & scaffold dasar (header, main, footer, navigasi antar-view).             | - `index.html` punya `<header>`, `<main>`, `<footer>` semantik.<br>- Ada area daftar tugas & area form tambah tugas di `<main>`.<br>- `style.css` menerapkan layout flexbox/grid.<br>- Halaman terbuka tanpa error console.                                                                                          |
| **SRS-002** | Autentikasi sederhana (login) & pembedaan peran admin vs user, disimpan di `localStorage`. | - Form login memvalidasi username/password terhadap data tersimpan.<br>- Role user disimpan (`admin` / `user`) saat login berhasil.<br>- Menu admin hanya tampil jika role = admin.<br>- Logout menghapus sesi aktif.                                                                                                |
| **SRS-003** | Membuat tugas & mengelompokkannya ke dalam daftar/proyek.                                  | - Dropdown/daftar proyek berisi minimal 3 opsi (bisa ditambah user).<br>- Tugas baru wajib dikaitkan ke satu proyek/daftar.<br>- Tugas ditambahkan ke DOM via `createElement`, bukan `innerHTML` mentah.<br>- Tugas tersimpan di `localStorage` agar persist saat reload.                                            |
| **SRS-004** | Validasi real-time & penetapan prioritas + tenggat waktu pada tugas.                       | - Error muncul saat judul tugas kosong atau < 3 karakter.<br>- Error muncul saat tenggat waktu diisi tanggal yang sudah lewat.<br>- Prioritas dipilih dari 3 opsi (Rendah/Sedang/Tinggi) dengan indikator warna.<br>- Error hilang real-time saat input diperbaiki.                                                  |
| **SRS-005** | Menandai tugas selesai/belum selesai & filter tampilan.                                    | - Checkbox/tombol toggle mengubah status tugas.<br>- Tugas selesai tampil dengan gaya berbeda (mis. *strikethrough*).<br>- Filter tersedia: Semua / Belum Selesai / Selesai.<br>- Perubahan status tersimpan di `localStorage`.                                                                                      |
| **SRS-006** | Kolaborasi — pemilik tugas menambahkan pengguna lain & memantau progres.                   | - Pemilik tugas dapat memilih pengguna lain dari daftar terdaftar untuk ditambahkan ke tugasnya.<br>- Tugas kolaboratif menampilkan daftar kolaborator & progres (mis. status per kolaborator).<br>- Hanya pemilik tugas yang bisa menambah/menghapus kolaborator.<br>- Duplikat kolaborator tidak bisa ditambahkan. |
| **SRS-007** | Panel admin — tambah & hapus akun pengguna dalam sistem.                                   | - Panel admin hanya bisa diakses saat role = admin.<br>- Form tambah akun memvalidasi username unik.<br>- Tombol hapus menghapus akun dari `localStorage`.<br>- Akun yang dihapus tidak bisa lagi login.                                                                                                             |
| *SRS-008* | *Penugasan tugas kepada lebih dari satu anggota tim.*                                        | - Pemilik tugas dapat menugaskan satu tugas kepada lebih dari satu anggota tim.<br>- Anggota yang ditugaskan dapat melihat tugas tersebut.<br>- Daftar anggota yang ditugaskan ditampilkan pada tugas.<br>- Satu pengguna tidak dapat ditambahkan lebih dari satu kali pada tugas yang sama.                                      |
| *SRS-009* | *Pemantauan progres penyelesaian tugas dalam daftar/proyek.*                                 | - Sistem menampilkan jumlah tugas yang selesai dan belum selesai dalam suatu daftar/proyek.<br>- Sistem menampilkan persentase atau indikator progres penyelesaian.<br>- Progres diperbarui ketika tugas ditandai selesai.<br>- Progres dapat dilihat oleh anggota yang terlibat dalam daftar/proyek.                             |
| *SRS-010* | *Pendaftaran akun pengguna.*                                                                 | - Pengguna dapat melakukan pendaftaran akun.<br>- Pengguna wajib mengisi data yang diperlukan saat pendaftaran.<br>- Username yang sudah digunakan tidak dapat didaftarkan kembali.<br>- Akun yang berhasil didaftarkan dapat digunakan untuk login.                                                                              |
| *SRS-011* | *Validasi hak akses dan penolakan permintaan pengguna yang tidak berwenang.*                 | - Sistem memeriksa hak akses pengguna sebelum menjalankan suatu permintaan.<br>- Pengguna tidak dapat melakukan tindakan yang bukan menjadi haknya.<br>- Permintaan yang tidak memiliki hak akses ditolak oleh sistem.<br>- Sistem memberikan informasi ketika permintaan ditolak.                                                |
| *SRS-012* | *Proses sistem berjalan secara atomik.*                                                      | - Setiap proses yang terdiri dari beberapa langkah harus berhasil seluruhnya atau dibatalkan seluruhnya.<br>- Jika salah satu langkah gagal, seluruh perubahan pada proses tersebut dibatalkan.<br>- Sistem tidak menyimpan data dalam kondisi sebagian berhasil.<br>- Data tetap konsisten setelah proses berhasil maupun gagal. |
| **SRS-013** | **Validasi input pengguna dan keamanan database menggunakan prepared statement.** | - Seluruh input pengguna divalidasi sebelum diproses atau disimpan ke database.<br>- Query database yang menggunakan input pengguna wajib menggunakan prepared statement/parameterized query.<br>- Sistem tidak menggabungkan input pengguna secara langsung ke dalam string query SQL.<br>- Input yang tidak valid ditolak dan tidak diproses ke database.<br>- Sistem mencegah input pengguna digunakan untuk melakukan SQL Injection. |

## Pembagian Tugas (4 Programmer)

| **PIC** | **SRS yang Dikerjakan** | **Fokus** |
|---|---|---|
| **Programmer 1 - Putri** | SRS-001, SRS-002, SRS-003 | Struktur halaman, autentikasi, serta pembuatan dan pengelompokan tugas |
| **Programmer 2 - Merdeka** | SRS-004, SRS-005, SRS-006 | Validasi, prioritas & deadline, status tugas, serta kolaborasi |
| **Programmer 3 - Jessica** | SRS-007, SRS-008, SRS-009, SRS-013 | Panel admin, penugasan tugas kepada anggota, pemantauan progres, serta keamanan input dan database |
| **Programmer 4 - Misbachul** | SRS-010, SRS-011, SRS-012 | Pendaftaran pengguna, hak akses, serta proses sistem secara atomik |
## Struktur Folder

```text
jara-advance-todo/
├── index.html       # Halaman utama
├── style.css        # Gaya tampilan
├── script.js        # Logika aplikasi
├── .gitignore       # File yang di-ignor oleh Git
└── README.md        # Dokumentasi proyek
```
