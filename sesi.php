<?php
session_start(); // Memulai sesi

// Panggil koneksi database
include 'db_connect.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href = 'login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user']; // Ambil id_user dari sesi

// Query untuk mengambil data dari tabel tbl_belajar berdasarkan id_user dan status 0
$query = "SELECT * FROM tbl_belajar WHERE status = 0 AND id_user = ? ORDER BY tanggal ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link href="fontawesome/css/all.css" rel="stylesheet">
    <link href="sendiri.css" rel="stylesheet">
    <title>Manajemen Waktu</title>
</head>
<body>

    <!-- Sidebar -->
    <?php include 'sidebar.php' ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4 ms-2">
            <h1 class="mt-3">
                <figure>
                    <blockquote class="blockquote">
                        <p>DAFTAR SESI BELAJAR</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Daftar Sesi <cite title="Source Title">Manajemen Waktu</cite>
                    </figcaption>
                </figure>
            </h1>
        </div>

        <!-- Tabel Sesi Belajar -->
        <div class="container table-container mt-3">
            <!-- Tombol Tambah Sesi Belajar -->
            <a href="kelola_sesi.php" class="btn btn-primary mb-2">
                <i class="fa-solid fa-plus"></i> Tambah Sesi Belajar
            </a>

            <table class="table table-striped table-hover table-bordered table-sm shadow-sm mt-2">
                <thead>
                    <tr>
                        <th class="col-no">No.</th>
                        <th class="col-title">Judul</th>
                        <th class="col-date">Tanggal</th>
                        <th class="col-time">Jam Mulai</th>
                        <th class="col-time">Jam Akhir</th>
                        <th class="col-aksi">Aksi</th> <!-- Tambahkan kolom Aksi -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['judul']); ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= htmlspecialchars($row['jam_mulai']); ?></td>
                                <td><?= htmlspecialchars($row['jam_akhir']); ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="update_sesi.php?id_belajar=<?= $row['id_belajar']; ?>" class="btn btn-warning btn-sm" title="Edit Sesi Belajar">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="hapus_sesi.php?id_belajar=<?= $row['id_belajar']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus sesi ini?')" class="btn btn-danger btn-sm" title="Hapus Sesi Belajar">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                        <a href="selesai_sesi.php?id_belajar=<?= $row['id_belajar']; ?>" class="btn btn-success btn-sm" title="Selesai Sesi Belajar">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada sesi belajar yang dijadwalkan.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
