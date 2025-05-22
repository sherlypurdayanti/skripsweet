<?php
include '../../config/koneksi.php';

if (isset($_POST['id']) && isset($_POST['status_aktif'])) {
  $id = $_POST['id'];
  $status = $_POST['status_aktif'];

  $query = "UPDATE kriteria SET status_aktif = ? WHERE id = ?";
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "ii", $status, $id);

  if (mysqli_stmt_execute($stmt)) {
    echo 'success';
  } else {
    echo 'error';
  }
} else {
  echo 'invalid';
}
?>
