<?php
include "../../config/koneksi.php";

// Ambil data sub_kriteria beserta nama kriteria
$query = "SELECT sub_kriteria.*, kriteria.nama_kriteria 
          FROM sub_kriteria 
          INNER JOIN kriteria ON sub_kriteria.id_kriteria = kriteria.id_kriteria";
$result = mysqli_query($koneksi, $query);

// Ambil semua kriteria untuk dropdown
$kriteria_result = mysqli_query($koneksi, "SELECT * FROM kriteria");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Data Sub Kriteria</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    .card-header {
      font-weight: bold;
      text-align: left;
      color: white;
    }
    .card {
      margin-bottom: 20px;
    }
    .card-body {
      padding: 0;
    }
    th, td {
      font-size: 14px;
      white-space: nowrap;
    }
    .bg-custom, th {
      background-color: #044885 !important;
      color: white !important;
    }
    .btn-custom {
      background-color: #044885 !important;
      color: white !important;
      border: none;
    }
    .btn-custom:hover {
      background-color: #357ABD;
    }
    .content {
      overflow-x: hidden;
    }
  </style>
</head>
<body>
  <?php include "../sidebar.php" ?>

  <div class="content container mt-3">
    <div class="card shadow-sm">
      <div class="card-header bg-custom">
        <h5 class="mb-0">Data Sub Kriteria Penilaian</h5>
      </div>
      <div class="card-body">

        <!-- Tombol Tambah -->
        <div class="mb-3 text-end">
          <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i> Tambah Sub Kriteria
          </button>
        </div>

        <div class="row gx-3">
          <!-- Penilaian oleh Atasan -->
          <div class="col-md-6">
            <div class="card shadow">
              <div class="card-header bg-custom">Penilaian oleh Atasan</div>
              <div class="card-body p-3">
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead class="table-light text-center">
                      <tr>
                        <th>Kriteria</th>
                        <th>Sub Kriteria</th>
                        <th>Bobot (%)</th>
                        <th>Status Aktif</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      mysqli_data_seek($result, 0);
                      while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['bobot_atasan'] > 0) {
                          $statusLabel = $row['status_aktif'] ? 'Aktif' : 'Nonaktif';
                          $btnClass = $row['status_aktif'] ? 'btn-danger' : 'btn-success';
                          $labelTombol = $row['status_aktif'] ? 'Nonaktifkan' : 'Aktifkan';
                          ?>
                          <tr>
                            <td><?= htmlspecialchars($row['nama_kriteria']) ?></td>
                            <td><?= htmlspecialchars($row['nama_sub_kriteria']) ?></td>
                            <td class="text-center"><?= $row['bobot_atasan'] ?>%</td>
                            <td class="text-center status-label"><?= $statusLabel ?></td>
                            <td class="text-center">
                              <button type="button"
                                class="btn btn-sm toggle-status-btn <?= $btnClass ?>"
                                data-id_subkriteria="<?= $row['id_subkriteria'] ?>"
                                data-status="<?= $row['status_aktif'] ?>">
                                <?= $labelTombol ?>
                              </button>
                              <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_subkriteria'] ?>">Edit</button>
                            </td>
                          </tr>
                          <?php
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Penilaian oleh Rekan Kerja -->
          <div class="col-md-6">
            <div class="card shadow">
              <div class="card-header bg-custom">Penilaian oleh Rekan Kerja</div>
              <div class="card-body p-3">
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead class="table-light text-center">
                      <tr>
                        <th>Kriteria</th>
                        <th>Sub Kriteria</th>
                        <th>Bobot (%)</th>
                        <th>Status Aktif</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      mysqli_data_seek($result, 0);
                      while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['bobot_rekan'] > 0) {
                          $statusLabel = $row['status_aktif'] ? 'Aktif' : 'Nonaktif';
                          $btnClass = $row['status_aktif'] ? 'btn-danger' : 'btn-success';
                          $labelTombol = $row['status_aktif'] ? 'Nonaktifkan' : 'Aktifkan';
                          ?>
                          <tr>
                            <td><?= htmlspecialchars($row['nama_kriteria']) ?></td>
                            <td><?= htmlspecialchars($row['nama_sub_kriteria']) ?></td>
                            <td class="text-center"><?= $row['bobot_rekan'] ?>%</td>
                            <td class="text-center status-label"><?= $statusLabel ?></td>
                            <td class="text-center">
                              <button type="button"
                                class="btn btn-sm toggle-status-btn <?= $btnClass ?>"
                                data-id_subkriteria="<?= $row['id_subkriteria'] ?>"
                                data-status="<?= $row['status_aktif'] ?>">
                                <?= $labelTombol ?>
                              </button>
                              <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_subkriteria'] ?>">Edit</button>
                            </td>
                          </tr>
                          <?php
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1">
          <div class="modal-dialog">
            <form action="tambah_sub_kriteria.php" method="post" class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Tambah Sub Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label>Kriteria</label>
                  <select name="id_kriteria" class="form-select" required>
                    <option value="">Pilih Kriteria</option>
                    <?php
                    mysqli_data_seek($kriteria_result, 0);
                    while ($k = mysqli_fetch_assoc($kriteria_result)) : ?>
                      <option value="<?= $k['id_kriteria'] ?>"><?= htmlspecialchars($k['nama_kriteria']) ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label>Nama Sub Kriteria</label>
                  <input type="text" name="nama_sub_kriteria" class="form-control" required />
                </div>
                <div class="mb-3">
                  <label>Bobot Atasan (%)</label>
                  <input type="number" name="bobot_atasan" class="form-control" required min="0" max="100" />
                </div>
                <div class="mb-3">
                  <label>Bobot Rekan Kerja (%)</label>
                  <input type="number" name="bobot_rekan" class="form-control" required min="0" max="100" />
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Modal Edit -->
        <?php
        mysqli_data_seek($result, 0);
        while ($row = mysqli_fetch_assoc($result)) {
          ?>
          <div class="modal fade" id="modalEdit<?= $row['id_subkriteria'] ?>" tabindex="-1">
            <div class="modal-dialog">
              <form action="edit_sub_kriteria.php" method="post" class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Sub Kriteria</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" value="<?= $row['id_subkriteria'] ?>" />
                  <div class="mb-3">
                    <label>Nama Sub Kriteria</label>
                    <input type="text" name="nama_sub_kriteria" class="form-control" value="<?= htmlspecialchars($row['nama_sub_kriteria']) ?>" required />
                  </div>
                  <div class="mb-3">
                    <label>Bobot Atasan (%)</label>
                    <input type="number" name="bobot_atasan" class="form-control" value="<?= $row['bobot_atasan'] ?>" required min="0" max="100" />
                  </div>
                  <div class="mb-3">
                    <label>Bobot Rekan Kerja (%)</label>
                    <input type="number" name="bobot_rekan" class="form-control" value="<?= $row['bobot_rekan'] ?>" required min="0" max="100" />
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </div>

  <!-- Bootstrap & jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- AJAX toggle status -->
  <script>
    $(document).ready(function () {
      $('.toggle-status-btn').click(function () {
        const btn = $(this);
        const id = btn.data('id_subkriteria');
        const currentStatus = btn.data('status');
        const newStatus = currentStatus == 1 ? 0 : 1;

        btn.prop('disabled', true);

        $.ajax({
          url: 'toggle_sub.php',
          method: 'POST',
          data: {
            id_subkriteria: id,
            status_aktif: newStatus
          },
          success: function (response) {
            if (response.trim() === 'success') {
              btn.data('status', newStatus);
              btn.toggleClass('btn-success btn-danger');
              btn.text(newStatus == 1 ? 'Nonaktifkan' : 'Aktifkan');
              btn.closest('tr').find('td.status-label').text(newStatus == 1 ? 'Aktif' : 'Nonaktif');
            } else {
              alert('Gagal mengubah status: ' + response);
            }
          },
          error: function () {
            alert('Terjadi kesalahan saat menghubungi server.');
          },
          complete: function () {
            btn.prop('disabled', false);
          }
        });
      });
    });
  </script>
</body>
</html>
