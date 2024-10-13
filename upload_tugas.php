<?php
require 'db_connect.php'; // Pastikan Anda sudah menghubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $mapel = $_POST['mapel'];
    $tanggal = $_POST['datetime'];
    $deskripsi = $_POST['deskripsi'];
    
    // Menangani file upload
    $targetDir = "uploads/"; // Pastikan folder ini ada dan writable
    $targetFile = $targetDir . basename($_FILES["files"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Cek apakah file adalah PDF atau ZIP
    if ($fileType != "pdf" && $fileType != "zip") {
        echo "Hanya file PDF dan ZIP yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Cek jika $uploadOk adalah 0 karena ada kesalahan
    if ($uploadOk == 0) {
        echo "File tidak diunggah.";
    } else {
        // Jika semuanya baik, coba unggah file
        if (move_uploaded_file($_FILES["files"]["tmp_name"], $targetFile)) {
            // Simpan data tugas ke database
            $sql = "INSERT INTO tbl_tugas (judul, deskripsi, tanggal, id_user, mapel) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $id_user = 1; // Ganti dengan ID pengguna yang sesuai
            $stmt->bind_param("ssssi", $judul, $deskripsi, $tanggal, $id_user, $mapel);
            
            if ($stmt->execute()) {
                echo "Tugas berhasil ditambahkan.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
}

$conn->close();
?>
