<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama_kriteria = $_POST['nama_kriteria'];
    $bobot_atasan = $_POST['bobot_atasan'];
    $bobot_rekan = $_POST['bobot_rekan'];

    $query = "UPDATE kriteria SET nama_kriteria = ?, bobot_atasan = ?, bobot_rekan = ?
              WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "sddi", $nama_kriteria, $bobot_atasan, $bobot_rekan, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: kriteria.php?status=edit_sukses");
        exit;
    } else {
        echo "Gagal mengedit data.";
    }
}
?>
