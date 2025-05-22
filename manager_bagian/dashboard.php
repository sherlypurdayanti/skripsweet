<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
    #content {
    margin-left: 250px; /* menyesuaikan lebar sidebar */
    padding: 20px;
    width: calc(100% - 250px);
  }
  .bg-custom {
    background-color: #044885 !important;
    color: white !important;
  }
</style>
<body>
<?php include "sidebar.php" ?>

<!-- Konten -->
<div class="container-fluid py-4" id="content">
  <div class="card shadow">
    <div class="card-header bg-custom text-white">
      <h4 class="mb-0">Dashboard</h4>
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
  // Skor Rata-Rata (Bar Chart)
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

  // Perbandingan Penilaian (Bar Chart)
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

  // Penilai (Pie Chart)
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
