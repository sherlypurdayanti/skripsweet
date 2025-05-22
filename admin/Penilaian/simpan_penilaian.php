<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nip = $_POST['nip'];
  $tahun = $_POST['tahun'];

  // Validasi singkat
  if (empty($nip) || empty($tahun)) {
    die('NIP dan tahun harus diisi.');
  }

  // Simpan penilaian atasan
  if (isset($_POST['atasan']) && is_array($_POST['atasan'])) {
    foreach ($_POST['atasan'] as $id_sub => $nilai) {
      $id_sub = (int) $id_sub;
      $nilai = (int) $nilai;
      if ($nilai < 10 || $nilai > 100) continue;

      $sql = "INSERT INTO penilaian (nip, id_subkriteria, nilai, tahun, tipe_penilai) VALUES (?, ?, ?, ?, 'atasan')
              ON DUPLICATE KEY UPDATE nilai = VALUES(nilai)";
      $stmt = $koneksi->prepare($sql);
      $stmt->bind_param("siii", $nip, $id_sub, $nilai, $tahun);
      $stmt->execute();
      $stmt->close();
    }
  }

  // Simpan penilaian rekan kerja
  if (isset($_POST['rekan']) && is_array($_POST['rekan'])) {
    foreach ($_POST['rekan'] as $id_sub => $nilai) {
      $id_sub = (int) $id_sub;
      $nilai = (int) $nilai;
      if ($nilai < 10 || $nilai > 100) continue;

      $sql = "INSERT INTO penilaian (nip, id_subkriteria, nilai, tahun, tipe_penilai) VALUES (?, ?, ?, ?, 'rekan')
              ON DUPLICATE KEY UPDATE nilai = VALUES(nilai)";
      $stmt = $koneksi->prepare($sql);
      $stmt->bind_param("siii", $nip, $id_sub, $nilai, $tahun);
      $stmt->execute();
      $stmt->close();
    }
  }

  // Redirect kembali atau tampilkan pesan sukses
  header("Location: form_penilaian.php?nip=$nip&success=1");
  exit;
}
?>
