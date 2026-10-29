<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}
require 'koneksi.php';

// Mengambil kamus bahasa eksternal (termasuk logika penangkap ?lang=...)
require 'kamus_bahasa.php';

// Judul Halaman Khusus Index
$t_title = ($lang == 'en') ? 'Student Data Dashboard' : 'Data Calon Peserta Didik';
$t_add = ($lang == 'en') ? 'Add New Data' : 'Tambah Data Baru';
$t_logout = ($lang == 'en') ? 'Logout' : 'Keluar';
$t_btn_edit = ($lang == 'en') ? 'Edit' : 'Edit';
$t_btn_del = ($lang == 'en') ? 'Delete' : 'Hapus';
$t_confirm = ($lang == 'en') ? 'Are you sure you want to delete this data?' : 'Yakin ingin menghapus data ini?';

$data_siswa = [];
try {
    $stmt = $pdo->query("SELECT * FROM peserta_didik ORDER BY id DESC");
    $data_siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<h2 style='color:red;text-align:center;'>Error Database: " . $e->getMessage() . "</h2>");
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $t_title; ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 30px 20px; color: #333; }
        .container { max-width: 1400px; margin: 0 auto; background: #fff; padding: 35px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .top-buttons a { margin-right: 8px; }
        
        .lang-switch { background: #f0f2f5; padding: 8px 15px; border-radius: 20px; font-size: 13px; font-weight: bold; }
        .lang-switch a { text-decoration: none; color: #7f8c8d; margin: 0 5px; transition: color 0.3s; }
        .lang-switch a:hover { color: #2c3e50; }
        .lang-switch a.active { color: #3498db; border-bottom: 2px solid #3498db; }
        
        .welcome-label { background-color: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 8px; border-left: 5px solid #17a2b8; margin-bottom: 25px; text-align: center; font-size: 18px; font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.08); }
        
        /* CSS Banner Notifikasi Sukses dengan Efek Transisi Smooth */
        .success-msg { 
            background-color: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
            padding: 12px; 
            border-radius: 6px; 
            text-align: center; 
            margin-bottom: 20px; 
            font-weight: bold; 
            transition: opacity 0.5s ease; 
        }

        .btn { text-decoration: none; padding: 12px 20px; color: #fff; background-color: #3498db; border: none; border-radius: 6px; font-size: 14px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.15); display: inline-block; }
        .btn:hover { background-color: #2980b9; box-shadow: 0 6px 12px rgba(0,0,0,0.25); transform: translateY(-2px); }
        .btn-danger { background-color: #e74c3c; } .btn-danger:hover { background-color: #c0392b; }
        
        .table-wrapper { box-shadow: 0 8px 20px rgba(0,0,0,0.1); border-radius: 10px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; background-color: #fff; white-space: nowrap; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e0e0e0; font-size: 14px; }
        th { background-color: #2c3e50; color: #ffffff; text-transform: uppercase; font-size: 12px; }
        tr:nth-child(even) { background-color: #f8fcfd; } tr:hover { background-color: #eef2f5; }
        .action-links a { text-decoration: none; padding: 6px 10px; color: #fff; border-radius: 4px; font-size: 12px; font-weight: 600; margin-right: 3px; display: inline-block; box-shadow: 0 3px 5px rgba(0,0,0,0.15); transition: all 0.3s ease; }
        .action-links a:hover { box-shadow: 0 5px 8px rgba(0,0,0,0.2); transform: translateY(-1px); }
        .btn-edit { background-color: #f39c12; } .btn-edit:hover { background-color: #e67e22; }
        .btn-del { background-color: #e74c3c; } .btn-del:hover { background-color: #c0392b; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Bagian Atas: Tombol Aksi di Kiri dan Tombol Bahasa di Kanan -->
        <div class="top-bar">
            <div class="top-buttons">
                <a href="tambah.php" class="btn"><?php echo $t_add; ?></a>
                <a href="logout.php" class="btn btn-danger"><?php echo $t_logout; ?></a>
            </div>
            <div class="lang-switch">
                <a href="?lang=id" class="<?php echo ($lang == 'id') ? 'active' : ''; ?>">ID</a> | 
                <a href="?lang=en" class="<?php echo ($lang == 'en') ? 'active' : ''; ?>">EN</a>
            </div>
        </div>

        <!-- Banner Notifikasi Sukses -->
        <?php if (isset($_SESSION['pesan_sukses'])): ?>
            <div class="success-msg" id="alert-msg">
                <?php
                    if ($_SESSION['pesan_sukses'] == 'deleted') {
                        echo $t_msg_deleted;
                    } elseif ($_SESSION['pesan_sukses'] == 'added') {
                        echo $t_msg_added;
                    } elseif ($_SESSION['pesan_sukses'] == 'updated') {
                        echo $t_msg_updated;
                    }
                    unset($_SESSION['pesan_sukses']); // Hapus session agar tidak muncul berulang kali
                ?>
            </div>
        <?php endif; ?>

        <div class="welcome-label"><?php echo $t_title; ?></div>
        
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>No</th>
                    <th><?php echo $t_th_name; ?></th>
                    <th><?php echo $t_th_gender; ?></th>
                    <th><?php echo $t_th_religion; ?></th>
                    <th>NIK</th>
                    <th>No. KK</th>
                    <th><?php echo $t_th_dob; ?></th>
                    <th><?php echo $t_th_father; ?></th>
                    <th><?php echo $t_th_mother; ?></th>
                    <th><?php echo $t_th_address; ?></th>
                    <th><?php echo $t_th_phone; ?></th>
                    <th><?php echo $t_th_ext; ?></th>
                    <th style="text-align: center;"><?php echo $t_th_act; ?></th>
                </tr>
                <?php $no = 1; foreach ($data_siswa as $row): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                    <td><?php echo htmlspecialchars($row['agama']); ?></td>
                    <td><?php echo htmlspecialchars($row['nik']); ?></td>
                    <td><?php echo htmlspecialchars($row['no_kk']); ?></td>
                    <td><?php echo htmlspecialchars($row['tempat_tanggal_lahir']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_ayah']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_ibu']); ?></td>
                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($row['no_tlp'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['ekstrakurikuler']); ?></td>
                    <td class="action-links" style="text-align: center;">
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit"><?php echo $t_btn_edit; ?></a>
                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn-del" onclick="return confirm('<?php echo $t_confirm; ?>');"><?php echo $t_btn_del; ?></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <!-- JavaScript Timer 10 Detik -->
    <script>
        setTimeout(function() {
            var alertBox = document.getElementById('alert-msg');
            if (alertBox) {
                alertBox.style.opacity = "0"; // Efek memudar selama 0.5 detik
                setTimeout(function() {
                    alertBox.style.display = "none"; // Menghilangkan elemen dari halaman
                }, 500);
            }
        }, 10000); // 10000 milidetik = 10 detik
    </script>
</body>
</html>