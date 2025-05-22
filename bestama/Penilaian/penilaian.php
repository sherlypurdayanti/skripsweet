<?php
include '../../config/koneksi.php';

// Ambil filter dari URL
$nipFilter        = isset($_GET['nip']) ? mysqli_real_escape_string($koneksi, $_GET['nip']) : '';
$namaFilter       = isset($_GET['nama']) ? mysqli_real_escape_string($koneksi, $_GET['nama']) : '';
$perusahaanFilter = isset($_GET['perusahaan']) ? mysqli_real_escape_string($koneksi, $_GET['perusahaan']) : '';
$periodeFilter    = isset($_GET['periode']) ? mysqli_real_escape_string($koneksi, $_GET['periode']) : '';

// Bangun klausa WHERE
$where = [];
if ($nipFilter)        $where[] = "p.nip_dinilai = '$nipFilter'";
if ($namaFilter)       $where[] = "k.nama LIKE '%$namaFilter%'";
if ($perusahaanFilter) $where[] = "k.perusahaan = '$perusahaanFilter'";
if ($periodeFilter)    $where[] = "pp.id_periode = '$periodeFilter'";
$where_sql = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Query gabungan data penilaian
$sql = "
SELECT
  p.id_penilaian,
  p.nip_dinilai,
  k.nama,
  k.perusahaan,
  p.tipe_penilai,
  p.id_kriteria,
  kr.nama_kriteria,
  p.id_subkriteria,
  sk.nama_sub_kriteria,
  p.nilai,
  pp.nama_periode,
  p.tanggal_penilaian
FROM penilaian p
JOIN tabel_karyawan k ON p.nip_dinilai = k.nip
JOIN kriteria kr ON p.id_kriteria = kr.id_kriteria
JOIN sub_kriteria sk ON p.id_subkriteria = sk.id_subkriteria
JOIN periode_penilaian pp ON p.periode_id = pp.id_periode
" . $where_sql . "
ORDER BY p.tanggal_penilaian DESC
";

$result = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Penilaian</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .content { margin: 20px; }
    th, td { text-align: center; }
    .bg-custom { background-color: #044885 !important; color: #fff; }
  </style>
</head>
<body>
<?php include "../sidebar.php"; ?>
<div class="content">
  <div class="card mb-4">
    <div class="card-header bg-custom text-white">
      <h5>Filter Data Penilaian</h5>
    </div>
    <div class="card-body">
      <form method="GET" class="row g-2">
        <div class="col-md-3">
          <input type="text" name="nip" class="form-control" placeholder="NIP Dinilai" value="<?= htmlspecialchars($nipFilter) ?>">
        </div>
        <div class="col-md-3">
          <input type="text" name="nama" class="form-control" placeholder="Nama Dinilai" value="<?= htmlspecialchars($namaFilter) ?>">
        </div>
        <div class="col-md-3">
          <select name="perusahaan" class="form-select">
            <option value="">-- Perusahaan --</option>
            <?php
            $qq = mysqli_query($koneksi, "SELECT DISTINCT perusahaan FROM tabel_karyawan");
            while ($r = mysqli_fetch_assoc($qq)):
            ?>
            <option value="<?= htmlspecialchars($r['perusahaan']) ?>" <?= $perusahaanFilter == $r['perusahaan'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($r['perusahaan']) ?>
            </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-md-3">
          <select name="periode" class="form-select">
            <option value="">-- Periode --</option>
            <?php
            $qp = mysqli_query($koneksi, "SELECT id_periode, nama_periode FROM periode_penilaian WHERE status_aktif = 1");
            while ($rp = mysqli_fetch_assoc($qp)):
            ?>
            <option value="<?= $rp['id_periode'] ?>" <?= $periodeFilter == $rp['id_periode'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($rp['nama_periode']) ?>
            </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-primary">Terapkan Filter</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header bg-custom text-white">
      <h5>Data Hasil Penilaian</h5>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Perusahaan</th>
            <th>Penilai</th>
            <th>Kriteria</th>
            <th>Subkriteria</th>
            <th>Nilai</th>
            <th>Periode</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php $no=1; while($d = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($d['nip_dinilai']) ?></td>
              <td><?= htmlspecialchars($d['nama']) ?></td>
              <td><?= htmlspecialchars($d['perusahaan']) ?></td>
              <td><?= htmlspecialchars($d['tipe_penilai']) ?></td>
              <td><?= htmlspecialchars($d['nama_kriteria']) ?></td>
              <td><?= htmlspecialchars($d['nama_sub_kriteria']) ?></td>
              <td><?= $d['nilai'] ?></td>
              <td><?= htmlspecialchars($d['nama_periode']) ?></td>
              <td><?= $d['tanggal_penilaian'] ?></td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="10">Belum ada data penilaian.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
