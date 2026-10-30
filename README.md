# Sistem Informasi Manajemen Data Sederhana — Pendaftaran Calon Peserta Didik

Tugas 2 — Pemrograman Web (PHP & MySQL)

| | |
| --- | --- |
| **Nama** | Rizki Mardiansyah |
| **NIM** | 10124036 |
| **Kelas** | IF-1 |

## Deskripsi

Aplikasi web sederhana untuk mengelola data calon peserta didik sebuah sekolah. Dibangun dengan **PHP murni** (tanpa framework) dan **MySQL/MariaDB** menggunakan PDO. Seluruh halaman pengelolaan data diproteksi oleh sistem login berbasis `$_SESSION`, dan antarmuka mendukung dua bahasa (Indonesia dan Inggris).

## Fitur

**Pengolahan form & validasi**
- Form input HTML dengan metode `POST`
- Validasi kelengkapan data memakai percabangan `if-else` sebelum disimpan
- Sanitasi input dengan `htmlspecialchars()` untuk mencegah XSS

**Integrasi database & CRUD**
- Koneksi database menggunakan PDO (`koneksi.php`)
- **Create**: menambah data peserta didik baru
- **Read**: menampilkan seluruh data dalam tabel HTML
- **Update**: mengubah data berdasarkan `id` (form terisi otomatis)
- **Delete**: menghapus data dengan konfirmasi JavaScript
- Semua query memakai *Prepared Statements* untuk mencegah SQL Injection

**Pengelolaan session**
- Login dan logout dengan `$_SESSION`; halaman CRUD tidak bisa diakses tanpa login
- Dual bahasa (Indonesia / English) yang disimpan di `$_SESSION`, sehingga konsisten di semua halaman
- Notifikasi sukses tambah/ubah/hapus yang hilang otomatis setelah 10 detik

## Teknologi

- PHP 8.x
- MySQL / MariaDB
- HTML5 & CSS3
- JavaScript (konfirmasi hapus dan timer notifikasi)
- XAMPP (Apache + MySQL) sebagai lingkungan lokal

## Struktur Proyek

```
Tugas2_10124036_Rizki_Mardiansyah/
├── database/
│   └── db_sekolah.sql        # Skrip database (tabel users & peserta_didik)
└── HTML dan PHP/
    ├── koneksi.php           # Koneksi database (PDO)
    ├── kamus_bahasa.php      # Kamus terjemahan ID/EN + penyimpanan bahasa di session
    ├── login.php             # Halaman login
    ├── logout.php            # Hapus session lalu kembali ke login
    ├── index.php             # Dashboard (Read)
    ├── tambah.php            # Tambah data (Create)
    ├── edit.php              # Ubah data (Update)
    └── hapus.php             # Hapus data (Delete)
```

## Skema Database

Database: `db_sekolah`

**Tabel `users`**

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| id | INT | Primary Key, Auto Increment |
| username | VARCHAR(50) | UNIQUE |
| password | VARCHAR(255) | |

**Tabel `peserta_didik`**

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| id | INT | Primary Key, Auto Increment |
| nama | VARCHAR(100) | |
| jenis_kelamin | VARCHAR(20) | Laki-laki / Perempuan |
| agama | VARCHAR(50) | |
| nik | VARCHAR(20) | |
| no_kk | VARCHAR(20) | |
| tempat_tanggal_lahir | VARCHAR(100) | |
| nama_ayah | VARCHAR(100) | |
| nama_ibu | VARCHAR(100) | |
| alamat | TEXT | |
| no_tlp | VARCHAR(20) | |
| ekstrakurikuler | VARCHAR(50) | Pramuka, Paskibra, PMR, Futsal |

## Cara Menjalankan

1. **Instal XAMPP**, lalu jalankan modul **Apache** dan **MySQL** dari XAMPP Control Panel.
2. **Clone repository ini**:
   ```bash
   git clone https://github.com/<username-anda>/<nama-repo>.git
   ```
3. **Salin isi folder `HTML dan PHP`** ke dalam folder `htdocs` XAMPP, misalnya `C:\xampp\htdocs\tugas2\`.
4. **Import database**:
   - Buka `http://localhost/phpmyadmin`
   - Buka tab **Import**, pilih file `database/db_sekolah.sql`, lalu klik **Go**
   - Database `db_sekolah` beserta tabel dan akun admin akan terbuat otomatis
5. **Cek konfigurasi koneksi** di `koneksi.php`. Nilai bawaan XAMPP:
   ```php
   $host     = "localhost";
   $nama_db  = "db_sekolah";
   $username = "root";
   $password = "";
   ```
6. **Buka aplikasi** di browser: `http://localhost/tugas2/login.php`

## Akun Login

| Username | Password |
| --- | --- |
| `admin` | `admin123` |

## Alur Program

1. Pengguna membuka `login.php` dan memasukkan username serta password.
2. Jika cocok, `$_SESSION['status_login']` dibuat dan pengguna diarahkan ke `index.php`.
3. Dashboard menampilkan seluruh data peserta didik (data terbaru di atas).
4. **Tambah**: isi form di `tambah.php`, data divalidasi dan disanitasi, lalu disimpan dengan `INSERT`.
5. **Edit**: klik tombol Edit, `edit.php?id=...` menampilkan form terisi data lama, lalu disimpan dengan `UPDATE`.
6. **Hapus**: klik tombol Hapus, muncul konfirmasi, lalu `hapus.php?id=...` menjalankan `DELETE`.
7. **Ganti bahasa**: tautan ID / EN mengirim `?lang=id` atau `?lang=en`, pilihan disimpan di `$_SESSION['lang']`.
8. **Keluar**: `logout.php` menjalankan `session_destroy()` dan kembali ke halaman login.



