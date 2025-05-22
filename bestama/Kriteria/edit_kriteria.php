<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['id_kriteria']) &&
        isset($_POST['nama_kriteria']) &&
        isset($_POST['bobot_atasan']) &&
        isset($_POST['bobot_rekan'])
    ) {
        $id_kriteria = $_POST['id_kriteria'];
        $nama_kriteria = mysqli_real_escape_string($koneksi, $_POST['nama_kriteria']);
        $bobot_atasan = (float) $_POST['bobot_atasan'];
        $bobot_rekan = (float) $_POST['bobot_rekan'];

        $query = "UPDATE kriteria 
                  SET nama_kriteria = ?, 
                      bobot_atasan = ?, 
                      bobot_rekan = ? 
                  WHERE id_kriteria = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "sdds", $nama_kriteria, $bobot_atasan, $bobot_rekan, $id_kriteria);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: kriteria.php");
            exit();
        } else {
            echo "Gagal memperbarui data: " . mysqli_error($koneksi);
        }
    } else {
        echo "Data tidak lengkap!";
    }
}
?>
