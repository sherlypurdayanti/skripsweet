<?php
$nip = isset($_GET['nip']) ? $_GET['nip'] : '';
$nama = '';

// Ambil nama dari database jika nip tersedia
if (!empty($nip)) {
  include '../../config/koneksi.php';
  $query = mysqli_query($koneksi, "SELECT nama FROM tabel_karyawan WHERE nip = '$nip'");
  $data = mysqli_fetch_assoc($query);
  if ($data) {
    $nama = $data['nama'];
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Form Penilaian Karyawan</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS Kustom -->
  <style>
    body {
      background-color: #eef3f9;
      padding: 30px;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-wrapper {
      background-color: #f8f9fa;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      margin-bottom: 40px;
    }

    h4, h5 {
      color: #063970;
    }

    .form-label {
      font-weight: 500;
      color: #333;
    }

    .form-control, .form-select {
      border-radius: 8px;
      border: 1px solid #ced4da;
      transition: 0.3s;
    }

    .form-control:focus, .form-select:focus {
      border-color: #063970;
      box-shadow: 0 0 0 0.2rem rgba(6, 57, 112, 0.25);
    }

    .btn-primary {
      background-color: #063970;
      border: none;
      padding: 10px 20px;
      font-weight: 500;
      border-radius: 8px;
    }

    .btn-primary:hover {
      background-color: #052c5a;
    }

    hr {
      border-top: 2px solid #dee2e6;
    }
  </style>
</head>
<body>
<?php include "../sidebar.php" ?>
  <div class="container">
    <div class="form-wrapper">
      <h4 class="mb-4">Form Penilaian Karyawan</h4>
      <form action="simpan_penilaian.php" method="POST">

        <!-- Informasi Umum -->
        <div class="row mb-3">
        <div class="col-md-4">
            <label for="nip" class="form-label">NIP Karyawan</label>
            <input type="text" class="form-control" id="nip" name="nip" value="<?= htmlspecialchars($nip) ?>" readonly required>
          </div>
          <div class="col-md-4">
            <label for="nama" class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($nama) ?>" readonly required>
          </div>
          <div class="col-md-4">
            <label for="tahun" class="form-label">Tahun Penilaian</label>
            <input type="number" class="form-control" id="tahun" name="tahun" required>
          </div>
        </div>

        <!-- Penilaian oleh Atasan -->
        <h5 class="mt-4">Penilaian oleh Atasan</h5>
        <div class="row">
          <div class="col-md-4">
            <label class="form-label">Presensi</label>
            <input type="number" class="form-control" name="atasan_presensi" min="10" max="100" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Kehadiran</label>
            <input type="number" class="form-control" name="atasan_kehadiran" min="10" max="100" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Lembur</label>
            <input type="number" class="form-control" name="atasan_lembur" min="10" max="100" required>
          </div>
          <div class="col-md-6 mt-3">
            <label class="form-label">Kepemimpinan</label>
            <input type="number" class="form-control" name="atasan_kepemimpinan" min="10" max="100" required>
          </div>
          <div class="col-md-6 mt-3">
            <label class="form-label">Etika Kerja</label>
            <input type="number" class="form-control" name="atasan_etika" min="10" max="100" required>
          </div>
        </div>

        <hr>

        <!-- Penilaian oleh Rekan Kerja 1 -->
        <h5 class="mt-4">Penilaian oleh Rekan Kerja 1</h5>
        <div class="row">
          <div class="col-md-6">
            <label class="form-label">Datang Tepat Waktu</label>
            <input type="number" class="form-control" name="rekan1_datang" min="10" max="100" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Pulang Sesuai Jam</label>
            <input type="number" class="form-control" name="rekan1_pulang" min="10" max="100" required>
          </div>
          <div class="col-md-6 mt-3">
            <label class="form-label">Disiplin</label>
            <input type="number" class="form-control" name="rekan1_disiplin" min="10" max="100" required>
          </div>
          <div class="col-md-6 mt-3">
            <label class="form-label">Tanggung Jawab</label>
            <input type="number" class="form-control" name="rekan1_tanggungjawab" min="10" max="100" required>
          </div>
        </div>

        <hr>

        <!-- Penilaian oleh Rekan Kerja 2 -->
        <h5 class="mt-4">Penilaian oleh Rekan Kerja 2</h5>
        <div class="row">
          <div class="col-md-6">
            <label class="form-label">Datang Tepat Waktu</label>
            <input type="number" class="form-control" name="rekan2_datang" min="10" max="100" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Pulang Sesuai Jam</label>
            <input type="number" class="form-control" name="rekan2_pulang" min="10" max="100" required>
          </div>
          <div class="col-md-6 mt-3">
            <label class="form-label">Disiplin</label>
            <input type="number" class="form-control" name="rekan2_disiplin" min="10" max="100" required>
          </div>
          <div class="col-md-6 mt-3">
            <label class="form-label">Tanggung Jawab</label>
            <input type="number" class="form-control" name="rekan2_tanggungjawab" min="10" max="100" required>
          </div>
        </div>

        <hr>

        <!-- Penilaian oleh Rekan Kerja 3 -->
        <h5 class="mt-4">Penilaian oleh Rekan Kerja 3</h5>
        <div class="row">
          <div class="col-md-6">
            <label class="form-label">Datang Tepat Waktu</label>
            <input type="number" class="form-control" name="rekan3_datang" min="10" max="100" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Pulang Sesuai Jam</label>
            <input type="number" class="form-control" name="rekan3_pulang" min="10" max="100" required>
          </div>
          <div class="col-md-6 mt-3">
            <label class="form-label">Disiplin</label>
            <input type="number" class="form-control" name="rekan3_disiplin" min="10" max="100" required>
          </div>
          <div class="col-md-6 mt-3">
            <label class="form-label">Tanggung Jawab</label>
            <input type="number" class="form-control" name="rekan3_tanggungjawab" min="10" max="100" required>
          </div>
        </div>

        <div class="mt-4 text-end">
          <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
        </div>

      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
