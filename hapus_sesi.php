<?php
session_start();
include 'db_connect.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href = 'login.php';</script>";
    exit;
}

$id_belajar = $_GET['id_belajar']; // Ambil id_belajar dari URL

// Query untuk menghapus sesi belajar
$query = "DELETE FROM tbl_belajar WHERE id_belajar = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_belajar);

if ($stmt->execute()) {
    // Set notifikasi di sesi
    $_SESSION['notif'] = "Sesi belajar berhasil dihapus!";
    header("Location: sesi.php"); // Redirect ke halaman daftar sesi belajar
} else {
    echo "<script>alert('Gagal menghapus sesi belajar!'); window.location.href = 'manajemen_waktu.php';</script>";
}
