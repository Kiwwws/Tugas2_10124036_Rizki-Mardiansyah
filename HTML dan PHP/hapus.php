<?php
session_start();
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}
require 'koneksi.php';

// Hapus data berdasarkan ID
if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM peserta_didik WHERE id = :id");
        $stmt->execute([':id' => $_GET['id']]);
        
        // Simpan penanda bahwa data berhasil dihapus
        $_SESSION['pesan_sukses'] = 'deleted';
    } catch (PDOException $e) {
        die("Error saat menghapus data: " . $e->getMessage());
    }
}

// Kembalikan ke halaman utama
header("Location: index.php");
exit;
?>