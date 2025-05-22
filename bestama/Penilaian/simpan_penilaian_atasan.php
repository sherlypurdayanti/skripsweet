<?php
include '../../config/koneksi.php';

$nip = $_POST['nip'];
$nama = $_POST['nama'];
$tahun = date('Y');
$penilai = 'atasan';
$nilai = $_POST['nilai'];

// Simpan ke tabel penilaian_atasan
foreach ($nilai as $id_sub => $nilai_input) {
    $query = "INSERT INTO penilaian (
        nip_karyawan, tahun, id_subkriteria, nilai, penilai
    ) VALUES (
        '$nip', '$tahun', '$id_sub', '$nilai_input', '$penilai'
    )";
    mysqli_query($koneksi, $query);
}

header("Location: form_penilaian_atasan.php?nip=$nip&success=1");
