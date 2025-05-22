<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $jabatan = $_POST['jabatan'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $status = $_POST['status'];
    $perusahaan = $_POST['perusahaan'];
    
    $query = "INSERT INTO tabel_karyawan (nip, nama, bagian, jabatan,tanggal_masuk, status, perusahaan) VALUES ('$nip', '$nama', '$bagian', '$jabatan','$tanggal_masuk','$status' ,'$perusahaan')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil ditambahkan'); window.location.href='karyawan.php';</script>";
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
}
?>
