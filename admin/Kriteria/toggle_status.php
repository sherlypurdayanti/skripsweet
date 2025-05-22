<?php
include '../../config/koneksi.php';

if(isset($_POST['id'], $_POST['status_aktif'])) {
  $id = (int)$_POST['id'];
  $status_aktif = (int)$_POST['status_aktif'];

  // Update status_aktif
  $query = "UPDATE kriteria SET status_aktif = $status_aktif WHERE id = $id";
  if(mysqli_query($koneksi, $query)) {
    echo 'success';
  } else {
    echo 'error';
  }
} else {
  echo 'invalid';
}
