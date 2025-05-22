<?php
include "../../config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama_sub_kriteria = $_POST['nama_sub_kriteria'];
    $bobot_atasan = $_POST['bobot_atasan'];
    $bobot_rekan = $_POST['bobot_rekan'];

    $query = "UPDATE sub_kriteria SET nama_sub_kriteria = ?, bobot_atasan = ?, bobot_rekan = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "sddi", $nama_sub_kriteria, $bobot_atasan, $bobot_rekan, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: subkriteria.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Invalid request method.";
}
?>
