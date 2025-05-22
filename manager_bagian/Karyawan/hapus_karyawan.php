<?php
include '../../config/koneksi.php';

if (isset($_GET['nip'])) {
    $nip = mysqli_real_escape_string($koneksi, $_GET['nip']);

    $query = "DELETE FROM tabel_karyawan WHERE nip = '$nip'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil dihapus'); window.location.href='karyawan.php';</script>";
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    echo "<script>alert('NIP tidak ditemukan'); window.location.href='karyawan.php';</script>";
}
?>
