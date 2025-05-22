<?php
include '../../config/koneksi.php';

$nip = isset($_GET['nip']) ? $_GET['nip'] : '';
$nama = '';

if (!empty($nip)) {
  $query = mysqli_query($koneksi, "SELECT nama FROM tabel_karyawan WHERE nip = '$nip'");
  $data = mysqli_fetch_assoc($query);
  if ($data) {
    $nama = $data['nama'];
  }
}

$kriteria = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE aktif = 1 AND tipe_penilai = 'atasan'");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Form Penilaian Atasan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h4>Form Penilaian oleh Atasan</h4>
  <form action="simpan_penilaian_atasan.php" method="POST">
    <input type="hidden" name="nip" value="<?= $nip ?>">
    <input type="hidden" name="nama" value="<?= $nama ?>">
    <div class="mb-3">
      <label class="form-label">Nama: <?= $nama ?> (<?= $nip ?>)</label>
    </div>
    <?php while ($k = mysqli_fetch_assoc($kriteria)): ?>
      <h5><?= $k['nama_kriteria'] ?></h5>
      <?php
        $id_kriteria = $k['id'];
        $sub = mysqli_query($koneksi, "SELECT * FROM sub_kriteria WHERE id_kriteria = $id_kriteria AND aktif = 1");
        while ($s = mysqli_fetch_assoc($sub)):
      ?>
        <div class="mb-3">
          <label class="form-label"><?= $s['nama_subkriteria'] ?></label>
          <input type="number" class="form-control" name="nilai[<?= $s['id'] ?>]" min="10" max="100" required>
        </div>
      <?php endwhile; ?>
    <?php endwhile; ?>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
</div>
</body>
</html>
