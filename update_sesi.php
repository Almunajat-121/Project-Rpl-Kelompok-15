<?php
// Mulai session dan panggil koneksi database
session_start();
include 'db_connect.php';

// Inisialisasi variabel untuk mengisi form
$id_belajar = '';
$judul = '';
$tanggal = '';
$jam_mulai = '';
$jam_akhir = '';
$button_text = 'Update'; // Tombol untuk update
$action_url = 'update_sesi.php'; // Default untuk mengupdate sesi

// Cek apakah id_belajar diterima dari URL
if (isset($_GET['id_belajar'])) {
    $id_belajar = intval($_GET['id_belajar']); // Ambil ID dari URL dan pastikan tipe data

    // Query untuk mengambil data sesi belajar berdasarkan id_belajar
    $query = "SELECT * FROM tbl_belajar WHERE id_belajar = $id_belajar";
    $result = $conn->query($query);

    // Periksa jika ada data
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Ambil data sesi belajar
        $judul = $row['judul'];
        $tanggal = $row['tanggal'];
        $jam_mulai = $row['jam_mulai'];
        $jam_akhir = $row['jam_akhir'];
    } else {
        echo "Sesi belajar tidak ditemukan.";
        exit; // Jika tidak ada data, hentikan eksekusi
    }
} else {
    echo "ID sesi belajar tidak valid.";
    exit; // Jika ID tidak ada, hentikan eksekusi
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link href="sendiri.css" rel="stylesheet">
    <link href="fontawesome/css/solid.css" rel="stylesheet">
    <link href="fontawesome/css/fontawesome.css" rel="stylesheet">
    <title>Edit Sesi Belajar</title>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand ms-2">Manajemen Waktu</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="container mt-4 ms-2">
            <h1 class="mt-3">
                <figure>
                    <blockquote class="blockquote">
                        <p>UBAH SESI BELAJAR</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Form Sesi Belajar <cite title="Source Title">Manajemen Waktu</cite>
                    </figcaption>
                </figure>
            </h1>
        </div>

        <!-- Form untuk update sesi -->
        <div class="container table-container mt-3">
            <form action="<?= $action_url ?>?id_belajar=<?= $id_belajar ?>" method="POST">
                <!-- Tambahkan input hidden untuk id_belajar -->
                <input type="hidden" name="id_belajar" value="<?= $id_belajar ?>">

                <div class="mb-3 row">
                    <label for="judul" class="col-sm-2 col-form-label">
                        MATA PELAJARAN
                    </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan mata pelajaran" value="<?= $judul ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tanggal" class="col-sm-2 col-form-label">
                        TANGGAL
                    </label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tanggal" value="<?= $tanggal ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jam_mulai" class="col-sm-2 col-form-label">
                        JAM MULAI
                    </label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" name="jam_mulai" value="<?= $jam_mulai ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jam_akhir" class="col-sm-2 col-form-label">
                        JAM AKHIR
                    </label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" name="jam_akhir" value="<?= $jam_akhir ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> <?= $button_text ?>
                        </button>
                        <button type="reset" class="btn btn-danger ml-2 mt-3">
                            <i class="fas fa-times"></i> Batalkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
