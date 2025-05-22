<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_subkriteria'] ?? '';
    $status = $_POST['status_aktif'] ?? '';

    // Validasi
    if ($id === '' || $status === '') {
        echo "Invalid data: id_subkriteria='$id', status=$status";
        exit;
    }

    // Update status
    $query = "UPDATE sub_kriteria SET status_aktif = ? WHERE id_subkriteria = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'is', $status, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "Gagal mengubah status: " . mysqli_error($koneksi);
    }
} else {
    echo "Metode tidak diperbolehkan.";
}
