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


    <!-- Sidebar -->

    <?php include 'sidebar.php' ?>

    <!-- Main Content -->

    <?php
// Tangkap parameter 'pesan' dari URL
if (isset($_GET['pesan'])) {
    $pesan = $_GET['pesan'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <script>
        // Fungsi untuk menampilkan pop-up berdasarkan pesan dari URL
        function showNotification(pesan) {
            if (pesan === 'delete_success') {
                alert('Tugas berhasil dihapus!');
            } else if (pesan === 'invalid_id') {
                alert('ID Tugas tidak valid!');
            }
        }

        // Cek apakah ada parameter 'pesan' di URL
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const pesan = urlParams.get('pesan');
            if (pesan) {
                showNotification(pesan);
            }
        };
    </script>
</head>
<body>
    <!-- Konten halaman tugas.php di sini -->
</body>
</html>

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
