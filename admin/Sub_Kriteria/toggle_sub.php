<?php
include '../../config/koneksi.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = "UPDATE sub_kriteria SET status_aktif=? WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ii", $status, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: subkriteria.php");
        exit;
    } else {
        echo "Gagal memperbarui status.";
    }
} else {
    echo "Permintaan tidak valid.";
}
