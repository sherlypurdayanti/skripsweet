<?php
include "../../config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kriteria_id = $_POST['kriteria_id'];
    $nama_sub_kriteria = $_POST['nama_sub_kriteria'];
    $bobot_atasan = $_POST['bobot_atasan'];
    $bobot_rekan = $_POST['bobot_rekan'];

    // Validasi sederhana bisa ditambah jika perlu

    $query = "INSERT INTO sub_kriteria (kriteria_id, nama_sub_kriteria, bobot_atasan, bobot_rekan) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "isdd", $kriteria_id, $nama_sub_kriteria, $bobot_atasan, $bobot_rekan);

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
