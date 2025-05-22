<?php
include '../../config/koneksi.php';

$nip = $_POST['nip'];
$nama = $_POST['nama'];
$tahun = date('Y');
$penilai = 'rekan';
$nilai = $_POST['nilai'];

// Simpan ke tabel penilaian_rekan (atau bisa digabung ke tabel penilaian jika satu tabel)
foreach ($nilai as $id_sub => $nilai_input) {
    $query = "INSERT INTO penilaian (
        nip_karyawan, tahun, id_subkriteria, nilai, penilai
    ) VALUES (
        '$nip', '$tahun', '$id_sub', '$nilai_input', '$penilai'
    )";
    mysqli_query($koneksi, $query);
}

header("Location: form_penilaian_rekan.php?nip=$nip&success=1");
