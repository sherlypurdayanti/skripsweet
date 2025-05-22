<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kriteria = mysqli_real_escape_string($koneksi, $_POST['nama_kriteria']);
    $bobot_atasan = (float) $_POST['bobot_atasan'];
    $bobot_rekan = (float) $_POST['bobot_rekan'];
    $status_aktif = 1; // default aktif saat ditambahkan

    // 1. Ambil id_kriteria terbesar yang ada
    $result = mysqli_query($koneksi, "SELECT MAX(CAST(SUBSTRING(id_kriteria, 2) AS UNSIGNED)) AS max_id FROM kriteria");
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['max_id'] ?? 0;

    // 2. Tambahkan 1 dan format jadi Kxx
    $newIdNumber = $lastId + 1;
    $id_kriteria = 'K' . str_pad($newIdNumber, 2, '0', STR_PAD_LEFT); // contoh: K01, K02, dst

    // 3. Simpan data
    $query = "INSERT INTO kriteria (id_kriteria, nama_kriteria, bobot_atasan, bobot_rekan, status_aktif)
              VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ssddi", $id_kriteria, $nama_kriteria, $bobot_atasan, $bobot_rekan, $status_aktif);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: kriteria.php");
        exit();
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
} else {
    echo "Metode tidak diperbolehkan.";
}
?>
