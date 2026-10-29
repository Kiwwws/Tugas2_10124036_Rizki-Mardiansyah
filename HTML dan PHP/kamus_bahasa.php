<?php
// 1. Logika Peralihan Bahasa (Menangkap query ?lang=id atau ?lang=en)
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// 2. Setel Bahasa Aktif dalam Session (Default: Indonesia)
$lang = $_SESSION['lang'] ?? 'id';

// 3. Kamus Terjemahan Global

// Pesan Notifikasi Sukses
$t_msg_deleted = ($lang == 'en') ? 'Data successfully deleted!' : 'Data berhasil dihapus!';
$t_msg_added   = ($lang == 'en') ? 'Data successfully added!' : 'Data berhasil ditambahkan!';
$t_msg_updated = ($lang == 'en') ? 'Data successfully updated!' : 'Data berhasil diperbarui!';

// Umum & Tombol
$t_btn_save    = ($lang == 'en') ? 'Save Data' : 'Simpan Data';
$t_back        = ($lang == 'en') ? '← Back to Dashboard' : '← Kembali ke Dashboard';
$t_err_msg     = ($lang == 'en') ? 'Make sure Name, NIK, KK, and Phone are filled!' : 'Pastikan Nama, NIK, No. KK, dan No. Telepon terisi!';

// Halaman Login
$t_login       = ($lang == 'en') ? 'Login' : 'Masuk';
$t_user        = ($lang == 'en') ? 'Username' : 'Nama Pengguna';
$t_pass        = ($lang == 'en') ? 'Password' : 'Kata Sandi';
$t_login_title = ($lang == 'en') ? 'Admin Login' : 'Login Admin Sekolah';
$t_err_login   = ($lang == 'en') ? 'Wrong username or password!' : 'Nama pengguna atau kata sandi salah!';

// Label Form Input (Tambah & Edit)
$t_lbl_name    = ($lang == 'en') ? 'Full Name' : 'Nama Lengkap';
$t_lbl_gender  = ($lang == 'en') ? 'Gender' : 'Jenis Kelamin';
$t_lbl_male    = ($lang == 'en') ? 'Male' : 'Laki-laki';
$t_lbl_female  = ($lang == 'en') ? 'Female' : 'Perempuan';
$t_lbl_rel     = ($lang == 'en') ? 'Religion' : 'Agama';
$t_lbl_sel     = ($lang == 'en') ? '--Select--' : '--Pilih--';
$t_lbl_nik     = ($lang == 'en') ? 'National ID Number (NIK)' : 'Nomor Induk Kependudukan (NIK)';
$t_lbl_kk      = ($lang == 'en') ? 'Family Card Number (KK)' : 'Nomor Kartu Keluarga (KK)';
$t_lbl_dob     = ($lang == 'en') ? 'Place & Date of Birth' : 'Tempat, Tanggal Lahir';
$t_lbl_father  = ($lang == 'en') ? "Father's Name" : 'Nama Ayah';
$t_lbl_mother  = ($lang == 'en') ? "Mother's Name" : 'Nama Ibu';
$t_lbl_address = ($lang == 'en') ? 'Full Address' : 'Alamat Lengkap';
$t_lbl_phone   = ($lang == 'en') ? 'Phone Number' : 'No. Telepon / HP';
$t_lbl_ext     = ($lang == 'en') ? 'Extracurricular' : 'Ekstrakurikuler';

// Tabel Dashboard (Index)
$t_th_name     = ($lang == 'en') ? 'Full Name' : 'Nama Lengkap';
$t_th_gender   = ($lang == 'en') ? 'M/F' : 'L/P';
$t_th_religion = ($lang == 'en') ? 'Religion' : 'Agama';
$t_th_dob      = ($lang == 'en') ? 'POB & DOB' : 'TTL';
$t_th_father   = ($lang == 'en') ? "Father's Name" : 'Nama Ayah';
$t_th_mother   = ($lang == 'en') ? "Mother's Name" : 'Nama Ibu';
$t_th_address  = ($lang == 'en') ? 'Address' : 'Alamat';
$t_th_phone    = ($lang == 'en') ? 'Phone' : 'No. Telepon';
$t_th_ext      = ($lang == 'en') ? 'Extracurricular' : 'Ekskul';
$t_th_act      = ($lang == 'en') ? 'Action' : 'Aksi';
?>