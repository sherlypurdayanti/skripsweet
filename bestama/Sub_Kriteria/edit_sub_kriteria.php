<?php
include "../../config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_subkriteria = $_POST['id'] ?? '';
    $nama_sub = mysqli_real_escape_string($koneksi, $_POST['nama_sub_kriteria'] ?? '');
    $bobot_atasan = (float)($_POST['bobot_atasan'] ?? 0);
    $bobot_rekan = (float)($_POST['bobot_rekan'] ?? 0);

    if (!$id_subkriteria || !$nama_sub) {
        echo "Data tidak lengkap.";
        exit;
    }

    $stmt = $koneksi->prepare("UPDATE sub_kriteria SET nama_sub_kriteria = ?, bobot_atasan = ?, bobot_rekan = ? WHERE id_subkriteria = ?");
    $stmt->bind_param("sdss", $nama_sub, $bobot_atasan, $bobot_rekan, $id_subkriteria);

    if ($stmt->execute()) {
        header("Location: subkriteria.php");
        exit();
    } else {
        echo "Gagal mengubah data: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Metode tidak diperbolehkan.";
}
?>
