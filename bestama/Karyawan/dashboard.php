<?php
include "../../config/koneksi.php";

// Ambil tahun aktif dari database
$query = $koneksi->query("SELECT tahun FROM periode_penilaian ORDER BY tahun DESC LIMIT 1");
if ($query && $data = $query->fetch_assoc()) {
    $tahun_aktif = $data['tahun'];
} else {
    $tahun_aktif = date('Y'); // fallback ke tahun saat ini jika tidak ada data
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    #content {
      margin-left: 250px;
      padding: 20px;
      width: calc(100% - 250px);
    }
    .bg-custom {
      background-color: #044885 !important;
      color: white !important;
    }
  </style>
</head>
<body>
<input type="hidden" id="tahunAktif" value="<?= $tahun_aktif ?>">
<?php include "sidebar.php"; ?>

<!-- Konten -->
<div class="container-fluid py-4" id="content">
  <div class="card shadow">
    <div class="card-header bg-custom text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Dashboard - Tahun <?= $tahun_aktif ?></h4>
      <a href="atur_penilaian.php" class="btn btn-light btn-sm text-dark">
        <i class="bi bi-gear me-1"></i> Atur Penilaian
      </a>
    </div>

    <div class="card-body">
      <div class="row">
        <!-- Skor Rata-Rata -->
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="text-center fw-bold text-uppercase mb-2">Skor Rata - Rata Penilaian</div>
          <canvas id="avgScoreChart" height="200"></canvas>
        </div>

        <!-- Perbandingan Penilaian -->
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="text-center fw-bold text-uppercase mb-2">Perbandingan Penilaian</div>
          <canvas id="comparisonChart" height="200"></canvas>
        </div>

        <!-- Penilai -->
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="text-center fw-bold text-uppercase mb-2">Penilai</div>
          <canvas id="reviewersChart" style="width: 100%; height: 250px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js Config -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tahunSelect = document.querySelector('select[name="tahun"]');
    const periodeSelect = document.querySelector('select[name="nama_periode"]');
    const tglMulai = document.querySelector('input[name="tanggal_mulai"]');
    const tglSelesai = document.querySelector('input[name="tanggal_selesai"]');

    function updateTanggal() {
        const tahun = parseInt(tahunSelect.value);
        const periode = periodeSelect.value;

        if (!tahun || !periode) return;

        if (periode.toLowerCase().includes('januari')) {
            // Periode Januari - Juni
            tglMulai.value = `${tahun}-06-03`;
            tglSelesai.value = `${tahun}-07-02`;
        } else if (periode.toLowerCase().includes('juli')) {
            // Periode Juli - Desember
            const nextYear = tahun + 1;
            tglMulai.value = `${tahun}-12-03`;
            tglSelesai.value = `${nextYear}-01-02`;
        } else {
            tglMulai.value = "";
            tglSelesai.value = "";
        }
    }
    // Jalankan saat halaman dimuat
    updateTanggal();

    // Jalankan ulang saat pilihan tahun atau periode berubah
    tahunSelect.addEventListener('change', updateTanggal);
    periodeSelect.addEventListener('change', updateTanggal);
});
  // Skor Rata-Rata
  new Chart(document.getElementById('avgScoreChart'), {
    type: 'bar',
    data: {
      labels: ['Januari - Juni 2023', 'Juli - Desember 2023', 'Januari - Juni 2024', 'Juli - Desember 2024'],
      datasets: [{
        label: 'Skor Rata-rata',
        data: [4.2, 3.8, 4.5, 4.0],
        backgroundColor: '#4CAF50'
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          max: 5
        }
      }
    }
  });

  // Perbandingan Penilaian
  new Chart(document.getElementById('comparisonChart'), {
    type: 'bar',
    data: {
      labels: ['Rekan Kerja', 'Atasan'],
      datasets: [{
        label: 'Skor Penilaian',
        data: [3.9, 4.1],
        backgroundColor: '#2196F3'
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          max: 5
        }
      }
    }
  });

  // Penilai (Pie)
  new Chart(document.getElementById('reviewersChart'), {
    type: 'pie',
    data: {
      labels: ['Atasan', 'Rekan Kerja'],
      datasets: [{
        label: 'Jumlah Penilaian',
        data: [25, 35],
        backgroundColor: ['#FF6384', '#36A2EB']
      }]
    },
    options: {
      responsive: false,
      maintainAspectRatio: false
    }
  });
</script>

</body>
</html>
