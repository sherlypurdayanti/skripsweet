<?php
include "../../config/koneksi.php";

$id = $_GET['id'];
$query = "UPDATE hasil_akhir SET keputusan = 'Disetujui' WHERE id_hasil = '$id'";
mysqli_query($koneksi, $query);

header("Location:../../../index.php"); // kembali ke halaman utama
exit;
