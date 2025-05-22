<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_kriteria']);
    $bobot_atasan = (float) $_POST['bobot_atasan'];
    $bobot_rekan = (float) $_POST['bobot_rekan'];
    $status = isset($_POST['status_aktif']) ? (int) $_POST['status_aktif'] : 1;

    $query = "UPDATE kriteria 
              SET nama_kriteria = '$nama',
                  bobot_atasan = '$bobot_atasan',
                  bobot_rekan = '$bobot_rekan',
                  status_aktif = '$status'
              WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: kriteria.php"); // Ganti dengan file utama jika berbeda
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>
