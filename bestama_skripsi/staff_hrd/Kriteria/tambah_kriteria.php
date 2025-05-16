
<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kriteria = $_POST['nama_kriteria'];
    $bobot_atasan = $_POST['bobot_atasan'];
    $bobot_rekan = $_POST['bobot_rekan'];

    $query = "INSERT INTO kriteria (nama_kriteria, bobot_atasan, bobot_rekan)
              VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "sdd", $nama_kriteria, $bobot_atasan, $bobot_rekan);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: kriteria.php?status=tambah_sukses");
        exit;
    } else {
        echo "Gagal menambahkan data.";
    }
}
?>
