<?php
// Panggil koneksi database
include 'db_connect.php';

// Query untuk mengambil data dari tabel tugas yang statusnya 0
$query = "SELECT * FROM tbl_tugas WHERE status = 0 ORDER BY tanggal ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="sendiri.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link href="fontawesome/css/solid.css" rel="stylesheet">
    <link href="fontawesome/css/fontawesome.css" rel="stylesheet">
    <title>Manajemen Waktu</title>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand ms-2">Manajemen Waktu</a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar shadow-sm">
        <div class="sidebar-header">
            <h5>Menu</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="beranda.php" class="nav-link">
                    <i class="fa-solid fa-home"></i>
                    Beranda
                </a>
            </li>
            <li class="list-group-item">
                <a href="sesi.php" class="nav-link">
                    <i class="fa-solid fa-calendar"></i>
                    Jadwal
                </a>
            </li>
            <li class="list-group-item">
                <a href="index.php" class="nav-link">
                    <i class="fa-solid fa-tasks"></i>
                    Tugas
                </a>
            </li>
            <li class="list-group-item">
                <a href="selesai.php" class="nav-link">
                    <i class="fa-solid fa-check-double"></i>
                    Selesai
                    <li class="list-group-item">
    <a href="logout.php" class="nav-link">
        <i class="fa-solid fa-sign-out-alt"></i>
        Keluar
    </a>
</li>

                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4 ms-2">
            <h1 class="mt-3">
                <figure>
                    <blockquote class="blockquote">
                        <p>DAFTAR TUGAS</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Daftar Tugas <cite title="Source Title">Manajemen Waktu</cite>
                    </figcaption>
                </figure>
            </h1>
        </div>

        <!-- Tabel Tugas -->
        <div class="container table-container mt-3">
            <a href="kelola.php" class="btn btn-primary mb-2">
                <i class="fa-solid fa-plus"></i>
                Tambah Tugas
            </a>
            <table class="table table-striped table-hover table-bordered table-sm shadow-sm mt-2">
                <thead>
                    <tr>
                        <th class="col-no">No.</th>
                        <th class="col-title">Judul Tugas</th>
                        <th class="col-mata-pelajaran">Mata Pelajaran</th>
                        <th class="col-desc">Deskripsi</th>
                        <th class="col-deadline">Tanggal & Jam Deadline</th>
                        <th class="col-action">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Periksa jika ada data di tabel
                    if ($result->num_rows > 0) {
                        $no = 1;
                        // Loop melalui setiap baris hasil query
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['judul']); ?></td>
                                <td><?= htmlspecialchars($row['mapel']); ?></td>
                                <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])); ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="kelola.php?id_tugas=<?= $row['id_tugas']; ?>" class="btn btn-warning btn-sm" title="Edit Tugas">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="delete_tugas.php?id_tugas=<?= $row['id_tugas']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus tugas ini?')" class="btn btn-danger btn-sm" title="Hapus Tugas">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                        <a href="selesai_tugas.php?id_tugas=<?= $row['id_tugas']; ?>" class="btn btn-success btn-sm" title="Selesai Tugas">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        // Jika tidak ada data
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada tugas yang ditambahkan.</td>
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
