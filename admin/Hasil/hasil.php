<?php
include "../../config/koneksi.php";

// Proses pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$whereClause = $search ? "WHERE nama LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%'" : "";

// Ambil data dari tabel hasil
$query = "SELECT * FROM hasil_akhir $whereClause";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Hasil Penilaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            width: 250px;
            background-color: #f8f9fa;
            flex-shrink: 0;
            border-right: 1px solid #dee2e6;
        }

        #main-content {
            flex-grow: 1;
            padding: 20px;
            margin-top: 50px;
        }
        .custom-header{
            background-color: #044885 !important;
            color: white !important;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .action-buttons .btn {
            margin-right: 5px;
        }
        th {
            background-color: #044885 !important;
            color: white !important;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Sidebar -->
    <div id="sidebar">
        <?php include "../sidebar.php"; ?>
    </div>

    <!-- Konten Utama -->
    <div id="main-content">
        <div class="card shadow">
            <div class="card-header custom-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Hasil Penilaian</h5>
                <!-- Form pencarian -->
                <form class="d-flex" method="get" action="">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari nama..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-sm btn-light">Cari</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>ID Hasil</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Nilai Akhir</th>
                                <th>Keputusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($row['id_hasil']) ?></td>
                                    <td><?= htmlspecialchars($row['nip']) ?></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['nilai_akhir']) ?></td>
                                    <td><?= htmlspecialchars($row['keputusan']) ?></td>
                                    <td class="text-center action-buttons">
                                        <a href="approve.php?id=<?= $row['id_hasil'] ?>" class="btn btn-success btn-sm">Approve</a>
                                        <a href="cetak.php?id=<?= $row['id_hasil'] ?>" target="_blank" class="btn btn-primary btn-sm">Cetak</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php if (mysqli_num_rows($result) == 0): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada data.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
