<?php
// Cek jika ada parameter status di URL
if (isset($_GET['status']) && $_GET['status'] == 'updated') {
    echo '<script>
            alert("Sesi belajar berhasil diperbarui!");
          </script>';
}
?>

<!-- Sisa kode HTML untuk halaman sesi.php -->

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
                        <p>DAFTAR SESI BELAJAR</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Daftar <cite title="Source Title">Sesi Belajar</cite>
                    </figcaption>
                </figure>
            </h1>
        </div>
        <!-- Tabel Sesi Belajar -->
        <div class="container table-container mt-3">
            <a href="kelola_sesi.php" class="btn btn-primary mb-2">
                <i class="fa-solid fa-plus"></i>
                Tambah Sesi Belajar
            </a>
            <table class="table table-striped table-hover table-bordered table-sm shadow-sm mt-2">
                <thead>
                    <tr>
                        <th class="col-no">No.</th>
                        <th class="col-tanggal">Tanggal</th>
                        <th class="col-mata-pelajaran">Mata Pelajaran</th>
                        <th class="col-jam-mulai">Jam Mulai</th>
                        <th class="col-jam-akhir">Jam Akhir</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Panggil koneksi database
                    include 'db_connect.php';

                    // Query untuk mengambil data dari tabel belajar dengan status=0
                    $query = "SELECT id_belajar, tanggal, judul, jam_mulai, jam_akhir 
                              FROM tbl_belajar 
                              WHERE status = 0
                              ORDER BY tanggal ASC";
                    $result = $conn->query($query);

                    // Periksa jika ada data di tabel
                    if ($result->num_rows > 0) {
                        $no = 1;
                        // Loop melalui setiap baris hasil query
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= htmlspecialchars($row['judul']); ?></td>
                                <td><?= htmlspecialchars($row['jam_mulai']); ?></td>
                                <td><?= htmlspecialchars($row['jam_akhir']); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a href="update_sesi.php?id_belajar=<?= $row['id_belajar']; ?>" class="dropdown-item" title="Edit Sesi Belajar">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" title="Hapus Sesi Belajar">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" title="Mulai/Pause Sesi Belajar">
                                                    <i class="fa-solid fa-play"></i> Mulai/Pause
                                                </button>
                                            </li>
                                            <li>
                                                 <a href="selesai_sesi.php?id_belajar=<?= $row['id_belajar']; ?>" class="dropdown-item" title="Selesai Sesi Belajar">
                                                    <i class="fa-solid fa-check"></i> Selesai
                                                 </a>
                                            </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        // Jika tidak ada data
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada sesi belajar yang ditambahkan.</td>
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
