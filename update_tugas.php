<?php
// Panggil koneksi ke database
include 'db_connect.php';

// Aktifkan laporan kesalahan PHP untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cek apakah form sudah di-submit dan data yang dibutuhkan tersedia
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tugas'])) {
    // Ambil data dari form
    $id_tugas = $_POST['id_tugas'];
    $judul = $_POST['judul'];
    $mapel = $_POST['mapel'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];

    // Debugging untuk memeriksa input (opsional, bisa dihapus setelah debugging)
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Pastikan semua field terisi
    if (!empty($judul) && !empty($mapel) && !empty($tanggal) && !empty($deskripsi)) {
        // Validasi bahwa id_tugas adalah integer
        if (filter_var($id_tugas, FILTER_VALIDATE_INT) === false) {
            echo "ID Tugas tidak valid!";
            exit;
        }

        // Query untuk mengupdate tugas berdasarkan id_tugas
        $query = "UPDATE tbl_tugas SET 
                    judul = ?, 
                    mapel = ?, 
                    tanggal = ?, 
                    deskripsi = ? 
                  WHERE id_tugas = ?";

        // Prepare statement untuk menghindari SQL Injection
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("ssssi", $judul, $mapel, $tanggal, $deskripsi, $id_tugas);

        // Eksekusi query
        if ($stmt->execute()) {
            // Jika berhasil, redirect ke halaman index.php dengan pesan sukses
            header("Location: index.php?pesan=update_success");
            exit();
        } else {
            // Jika gagal, tampilkan pesan error
            echo "Query gagal: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        // Jika ada field yang kosong, kembalikan ke form kelola dengan pesan error
        header("Location: kelola.php?id_tugas=$id_tugas&pesan=empty_fields");
        exit();
    }
} else {
    // Jika form tidak di-submit dengan benar, kembalikan ke index.php
    header("Location: index.php");
    exit();
}
?>
