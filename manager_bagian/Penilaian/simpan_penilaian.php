<?php
$nip = $_GET['nip'];
$conn = new mysqli("localhost", "user", "", "bestama_skripi");

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

$nip = $conn->real_escape_string($nip);
$result = $conn->query("SELECT nama FROM penialain WHERE nip = '$nip'");
$data = $result->fetch_assoc();

echo $data ? $data['nama'] : '';
?>
