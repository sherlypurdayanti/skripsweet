<?php
include '../../config/koneksi.php';

if (!empty($_POST['id_kriteria']) && isset($_POST['status_aktif'])) {
  $id = $_POST['id_kriteria'];
  $status = (int) $_POST['status_aktif'];

  $query = "UPDATE kriteria SET status_aktif = ? WHERE id_kriteria = ?";
  $stmt = mysqli_prepare($koneksi, $query);

  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "is", $status, $id);
    if (mysqli_stmt_execute($stmt)) {
      echo 'success';
    } else {
      echo 'error';
    }
    mysqli_stmt_close($stmt);
  } else {
    echo 'error';
  }
} else {
  echo 'invalid';
}
?>
