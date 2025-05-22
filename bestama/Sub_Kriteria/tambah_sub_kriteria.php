<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kriteria = $_POST['id_kriteria']; // id dari kriteria induk
    $nama_sub = mysqli_real_escape_string($koneksi, $_POST['nama_sub_kriteria']);
    $bobot_atasan = (float) $_POST['bobot_atasan'];
    $bobot_rekan = (float) $_POST['bobot_rekan'];
    $status_aktif = 1;

  // Ambil id_sub_kriteria terakhir
    $result = mysqli_query($koneksi, "SELECT MAX(CAST(SUBSTRING(id_subkriteria, 3) AS UNSIGNED)) AS max_id FROM sub_kriteria");
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['max_id'] ?? 0;

    $result = mysqli_query($koneksi, "SELECT * FROM sub_kriteria");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<pre>"; print_r($row); echo "</pre>";
    }

    do {
        $lastId++;
        $id_sub_kriteria = 'SK' . str_pad($lastId, 2, '0', STR_PAD_LEFT);
        $check = mysqli_query($koneksi, "SELECT 1 FROM sub_kriteria WHERE id_subkriteria = '$id_sub_kriteria'");
    } while (mysqli_num_rows($check) > 0);


    // Simpan data
    $query = "INSERT INTO sub_kriteria (id_subkriteria, id_kriteria, nama_sub_kriteria, bobot_atasan, bobot_rekan, status_aktif)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "sssddi", $id_sub_kriteria, $id_kriteria, $nama_sub, $bobot_atasan, $bobot_rekan, $status_aktif);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: subkriteria.php");
        exit();
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
} else {
    echo "Metode tidak diperbolehkan.";
}
?>
