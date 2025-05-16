<?php
include '../../config/koneksi.php'; // sesuaikan path jika perlu

$nip = isset($_GET['nip']) ? htmlspecialchars($_GET['nip']) : '';

$nama = '';
if ($nip) {
    $query = mysqli_query($koneksi, "SELECT nama FROM tabel_karyawan WHERE nip = '$nip'");
    if ($data = mysqli_fetch_assoc($query)) {
        $nama = $data['nama'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penilaian Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100%;
        background-color: #1a252f;
        padding-top: 20px;
    }
    .content {
        margin-left: 250px;
        padding: 20px;
    }
    .table-container {
        margin-top: 30px;
    }
    th, td {
        text-align: center;
    }
    th {
        background-color: #3498db; /* Warna latar belakang header */
        color: white; /* Warna teks header */
    }
</style>

</head>
<body>

<?php include '../sidebar.php'; ?>

<div class="content">
    <div class="container">        <?php if ($nip && $nama): ?>
        <div class="mb-4 p-3 bg-light border rounded shadow-sm">
            <h6><strong><?= htmlspecialchars($nip . ' - ' . $nama) ?></strong></h6>
        </div>
        <?php endif; ?>
        <div class="table-container">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center fw-bold">Tahun</th>
                        <th class="text-center fw-bold">Total Atasan</th>
                        <th class="text-center fw-bold">Total Rekan 1</th>
                        <th class="text-center fw-bold">Total Rekan 2</th>
                        <th class="text-center fw-bold">Total Rekan 3</th>
                        <th class="text-center fw-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh statis, silakan ganti dengan data dari database -->
                    <tr>
                        <td>2025</td>
                        <td>88</td>
                        <td>87</td>
                        <td>78</td>
                        <td>85</td>
                        <td>
                            <a href="form_penilaian.php?nip=<?= urlencode($nip) ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Penilaian
                            </a>
                        </td>
                    </tr>
                    <!-- Ulangi untuk data lain jika tersedia -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>