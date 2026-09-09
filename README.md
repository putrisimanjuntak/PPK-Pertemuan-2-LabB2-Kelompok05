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

## Pembagian Tugas (2 Programmer)

| **PIC**                                        | **SRS yang Dikerjakan**            | **Fokus**                                                                                     |
| ---------------------------------------------- | ---------------------------------- | --------------------------------------------------------------------------------------------- |
| **Programmer 1 - Misbachul Munir**             | SRS-001, SRS-003, SRS-004, SRS-005 | Scaffold halaman + inti manajemen tugas (CRUD, grouping, prioritas, deadline, status selesai) |
| **Programmer 2 - Jessica Laurencia Panjaitan** | SRS-002, SRS-006, SRS-007          | Autentikasi, role, kolaborasi antar-pengguna, panel admin                                     |

## Struktur Folder

```text
jara-advance-todo/
├── index.html       # Halaman utama
├── style.css        # Gaya tampilan
├── script.js        # Logika aplikasi
├── .gitignore       # File yang di-ignor oleh Git
└── README.md        # Dokumentasi proyek
```
