<?php
// Mulai session dan panggil koneksi database
session_start();
include 'db_connect.php';

// Cek apakah id_belajar diterima dari URL
if (isset($_GET['id_belajar'])) {
    $id_belajar = intval($_GET['id_belajar']); // Ambil ID dari URL dan pastikan tipe data

    // Query untuk mengambil data sesi belajar berdasarkan id_belajar
    $query = "SELECT * FROM tbl_belajar WHERE id_belajar = $id_belajar";
    $result = $conn->query($query);

    // Periksa jika ada data
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Ambil data sesi belajar
    } else {
        echo "Sesi belajar tidak ditemukan.";
        exit; // Jika tidak ada data, hentikan eksekusi
    }
} else {
    echo "ID sesi belajar tidak valid.";
    exit; // Jika ID tidak ada, hentikan eksekusi
}

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_belajar = $_POST['id_belajar'];
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_akhir = $_POST['jam_akhir'];
    $id_user = $_SESSION['id_user']; // Pastikan pengguna sudah login dan id_user tersimpan di session

    // Query untuk mengupdate data sesi belajar
    $query = "UPDATE tbl_belajar 
              SET judul = '$judul', tanggal = '$tanggal', jam_mulai = '$jam_mulai', jam_akhir = '$jam_akhir' 
              WHERE id_belajar = $id_belajar AND id_user = $id_user";

    // Eksekusi query
    if ($conn->query($query) === TRUE) {
        // Redirect ke halaman lain setelah berhasil mengupdate sesi
        header("Location: sesi.php?status=updated");
        exit();
    } else {
        // Tampilkan pesan error jika gagal
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Sesi Belajar</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Sesi Belajar</h1>
        <form action="update_sesi.php?id_belajar=<?= $id_belajar; ?>" method="POST">
            <input type="hidden" name="id_belajar" value="<?= $row['id_belajar']; ?>">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $row['tanggal']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label">Mata Pelajaran</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= htmlspecialchars($row['judul']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="<?= $row['jam_mulai']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jam_akhir" class="form-label">Jam Akhir</label>
                <input type="time" class="form-control" id="jam_akhir" name="jam_akhir" value="<?= $row['jam_akhir']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
