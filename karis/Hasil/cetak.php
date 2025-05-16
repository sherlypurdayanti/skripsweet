<?php
include "../../config/koneksi.php";

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$query = "SELECT * FROM hasil_akhir WHERE id_hasil = '$id'";
$result = mysqli_query($koneksi, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Data tidak ditemukan.");
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Hasil Penilaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 40px;
        }
        .print-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td {
            padding: 8px 12px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="print-title">
    <h4>Hasil Penilaian Karyawan</h4>
    <p><strong>ID Hasil:</strong> <?= htmlspecialchars($data['id_hasil']) ?></p>
</div>

<table class="table table-bordered info-table">
    <tr>
        <th width="30%">NIP</th>
        <td><?= htmlspecialchars($data['nip']) ?></td>
    </tr>
    <tr>
        <th>Nama</th>
        <td><?= htmlspecialchars($data['nama']) ?></td>
    </tr>
    <tr>
        <th>Nilai Akhir</th>
        <td><?= htmlspecialchars($data['nilai_akhir']) ?></td>
    </tr>
    <tr>
        <th>Keputusan</th>
        <td><?= htmlspecialchars($data['keputusan']) ?></td>
    </tr>
</table>

<div class="mt-4 text-end">
    <p>Dicetak pada: <?= date('d-m-Y H:i') ?></p>
</div>

<div class="no-print mt-4 text-center">
    <button class="btn btn-primary" onclick="window.print()">Cetak</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>
