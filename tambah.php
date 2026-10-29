<?php
session_start();
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}
require 'koneksi.php';

// Mengambil kamus bahasa eksternal (termasuk logika penangkap ?lang=...)
require 'kamus_bahasa.php';

// Judul Halaman Khusus Tambah
$t_title = ($lang == 'en') ? 'Add New Student' : 'Tambah Data Siswa Baru';

$error_msg = "";

if (isset($_POST['simpan'])) {
    $nama                 = htmlspecialchars($_POST['nama']);
    $jenis_kelamin        = htmlspecialchars($_POST['jenis_kelamin'] ?? '');
    $agama                = htmlspecialchars($_POST['agama']);
    $nik                  = htmlspecialchars($_POST['nik']);
    $no_kk                = htmlspecialchars($_POST['no_kk']);
    $tempat_tanggal_lahir = htmlspecialchars($_POST['tempat_tanggal_lahir']);
    $nama_ayah            = htmlspecialchars($_POST['nama_ayah']);
    $nama_ibu             = htmlspecialchars($_POST['nama_ibu']);
    $alamat               = htmlspecialchars($_POST['alamat']);
    $no_tlp               = htmlspecialchars($_POST['no_tlp']);
    $ekstrakurikuler      = htmlspecialchars($_POST['ekstrakurikuler']);

    if (empty($nama) || empty($nik) || empty($no_kk) || empty($no_tlp)) {
        $error_msg = $t_err_msg;
    } else {
        $stmt = $pdo->prepare("INSERT INTO peserta_didik (nama, jenis_kelamin, agama, nik, no_kk, tempat_tanggal_lahir, nama_ayah, nama_ibu, alamat, no_tlp, ekstrakurikuler) VALUES (:nama, :jk, :agama, :nik, :kk, :ttl, :ayah, :ibu, :alamat, :tlp, :ekskul)");
        $stmt->execute([':nama'=>$nama, ':jk'=>$jenis_kelamin, ':agama'=>$agama, ':nik'=>$nik, ':kk'=>$no_kk, ':ttl'=>$tempat_tanggal_lahir, ':ayah'=>$nama_ayah, ':ibu'=>$nama_ibu, ':alamat'=>$alamat, ':tlp'=>$no_tlp, ':ekskul'=>$ekstrakurikuler]);
        
        // Simpan status sukses tambah data
        $_SESSION['pesan_sukses'] = 'added';
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $t_title; ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 30px 20px; color: #333; display: flex; justify-content: center; }
        .container { background: #fff; padding: 35px 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 700px; position: relative; }
        h2 { text-align: center; color: #2c3e50; margin-top: 10px; margin-bottom: 25px; }
        .top-bar { position: absolute; top: 15px; right: 20px; }
        .lang-switch { background: #f0f2f5; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .lang-switch a { text-decoration: none; color: #7f8c8d; margin: 0 5px; transition: color 0.3s; }
        .lang-switch a:hover { color: #2c3e50; }
        .lang-switch a.active { color: #3498db; border-bottom: 2px solid #3498db; }
        .btn-back { display: inline-block; text-decoration: none; padding: 10px 15px; background-color: #7f8c8d; color: #fff; border-radius: 6px; font-size: 14px; font-weight: bold; margin-bottom: 20px; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-back:hover { background-color: #636e72; transform: translateY(-2px); box-shadow: 0 6px 12px rgba(0,0,0,0.15); }
        .error-msg { color: #c0392b; background-color: #fadbd8; padding: 10px; border-radius: 6px; text-align: center; margin-bottom: 20px; font-weight: bold; display: <?php echo empty($error_msg) ? 'none' : 'block'; ?>; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 12px 5px; vertical-align: top; }
        td:first-child { width: 35%; font-weight: 600; color: #555; padding-top: 18px; }
        input[type="text"], select, textarea { width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 15px; box-sizing: border-box; }
        input[type="text"]:focus, select:focus, textarea:focus { border-color: #3498db; outline: none; box-shadow: 0 0 8px rgba(52, 152, 219, 0.3); }
        textarea { resize: vertical; min-height: 80px; }
        .btn-submit { width: 100%; padding: 14px; background-color: #27ae60; color: #fff; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; margin-top: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.15); }
        .btn-submit:hover { background-color: #2ecc71; transform: translateY(-2px); box-shadow: 0 6px 12px rgba(0,0,0,0.25); }
    </style>
</head>
<body>
    <div class="container">
        <!-- Pilihan Bahasa -->
        <div class="top-bar">
            <div class="lang-switch">
                <a href="?lang=id" class="<?php echo ($lang == 'id') ? 'active' : ''; ?>">ID</a> | 
                <a href="?lang=en" class="<?php echo ($lang == 'en') ? 'active' : ''; ?>">EN</a>
            </div>
        </div>

        <h2><?php echo $t_title; ?></h2>
        <a href="index.php" class="btn-back"><?php echo $t_back; ?></a>
        <?php if (!empty($error_msg)): ?><div class="error-msg"><?php echo $error_msg; ?></div><?php endif; ?>
        
        <form method="POST">
            <table>
                <tr><td><?php echo $t_lbl_name; ?></td><td><input type="text" name="nama" required></td></tr>
                <tr>
                    <td><?php echo $t_lbl_gender; ?></td>
                    <td>
                        <label style="margin-right: 15px;"><input type="radio" name="jenis_kelamin" value="Laki-laki" required> <?php echo $t_lbl_male; ?></label>
                        <label><input type="radio" name="jenis_kelamin" value="Perempuan" required> <?php echo $t_lbl_female; ?></label>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $t_lbl_rel; ?></td>
                    <td>
                        <select name="agama" required>
                            <option value=""><?php echo $t_lbl_sel; ?></option>
                            <option value="Islam">Islam</option><option value="Kristen">Kristen</option><option value="Katolik">Katolik</option><option value="Hindu">Hindu</option>
                        </select>
                    </td>
                </tr>
                <tr><td><?php echo $t_lbl_nik; ?></td><td><input type="text" name="nik" required></td></tr>
                <tr><td><?php echo $t_lbl_kk; ?></td><td><input type="text" name="no_kk" required></td></tr>
                <tr><td><?php echo $t_lbl_dob; ?></td><td><input type="text" name="tempat_tanggal_lahir" required></td></tr>
                <tr><td><?php echo $t_lbl_father; ?></td><td><input type="text" name="nama_ayah" required></td></tr>
                <tr><td><?php echo $t_lbl_mother; ?></td><td><input type="text" name="nama_ibu" required></td></tr>
                <tr><td><?php echo $t_lbl_address; ?></td><td><textarea name="alamat" required></textarea></td></tr>
                <tr><td><?php echo $t_lbl_phone; ?></td><td><input type="text" name="no_tlp" required></td></tr>
                <tr>
                    <td><?php echo $t_lbl_ext; ?></td>
                    <td>
                        <select name="ekstrakurikuler" required>
                            <option value=""><?php echo $t_lbl_sel; ?></option>
                            <option value="Pramuka">Pramuka</option><option value="Paskibra">Paskibra</option><option value="PMR">PMR</option><option value="Futsal">Futsal</option>
                        </select>
                    </td>
                </tr>
                <tr><td></td><td><button type="submit" name="simpan" class="btn-submit"><?php echo $t_btn_save; ?></button></td></tr>
            </table>
        </form>
    </div>
</body>
</html>