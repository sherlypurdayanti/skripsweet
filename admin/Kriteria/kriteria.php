<?php
  include '../../config/koneksi.php'; 

  $query = "SELECT * FROM kriteria";
  $result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Data Kriteria</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    th, td {
      font-size: 14px;
    }
    thead th {
      background-color: #063970 !important;
      color: #ffffff !important;
      text-align: center;
    }
    .bg-custom, .btn-custom {
      background-color: #044885 !important;
      color: white !important;
    }
  </style>
</head>
<body>
  <?php include "../sidebar.php" ?>
  <div class="content">

      <!-- Tabel -->
      <div class="card shadow-sm mt-3">
        <div class="card-header bg-custom">
          <h5 class="mb-0">Tabel Data Kriteria Penilaian</h5>
        </div>
        <div class="card-body">
          <!-- Tombol Tambah di dalam card -->
          <div class="mb-3 text-start">
            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambah">
              <i class="bi bi-plus-circle me-1"></i> Tambah Kriteria
            </button>
          </div>
          <div class="col-md-10 offset-md-1">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Id Kriteria</th>
                  <th>Nama Kriteria</th>
                  <th>Bobot Atasan</th>
                  <th>Bobot Rekan Kerja</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                  <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nama_kriteria']) ?></td>
                    <td class="text-center"><?= $row['bobot_atasan'] !== null ? $row['bobot_atasan'] . "%" : "-" ?></td>
                    <td class="text-center"><?= $row['bobot_rekan'] !== null ? $row['bobot_rekan'] . "%" : "-" ?></td>
                    <td class="text-center">
                      <?php if ($row['status_aktif'] == 1): ?>
                        <button class="btn btn-sm btn-success toggle-status-btn" data-id="<?= $row['id'] ?>" data-status_aktif="1">Aktif</button>
                      <?php else: ?>
                        <button class="btn btn-sm btn-secondary toggle-status-btn" data-id="<?= $row['id'] ?>" data-status_aktif="0">Nonaktif</button>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>">Edit</button>
                    </td>
                  </tr>

                  <!-- Modal Edit -->
                  <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="edit_kriteria.php" method="post" class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Edit Kriteria</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" name="id" value="<?= $row['id'] ?>">
                          <div class="mb-3">
                            <label>Nama Kriteria</label>
                            <input type="text" name="nama_kriteria" class="form-control" value="<?= htmlspecialchars($row['nama_kriteria']) ?>" required>
                          </div>
                          <div class="mb-3">
                            <label>Bobot Atasan (%)</label>
                            <input type="number" name="bobot_atasan" class="form-control" value="<?= $row['bobot_atasan'] ?>" required>
                          </div>
                          <div class="mb-3">
                            <label>Bobot Rekan (%)</label>
                            <input type="number" name="bobot_rekan" class="form-control" value="<?= $row['bobot_rekan'] ?>" required>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label for="status_aktif" class="form-label">Status</label>
                          <select name="status_aktif" id="status" class="form-select" required>
                            <option value="1" <?= $row['status_aktif'] == 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= $row['status_aktif'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
                          </select>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                <?php endwhile; ?>
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
      <form action="tambah_kriteria.php" method="post" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kriteria</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Kriteria</label>
            <input type="text" name="nama_kriteria" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Bobot Atasan (%)</label>
            <input type="number" name="bobot_atasan" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Bobot Rekan (%)</label>
            <input type="number" name="bobot_rekan" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  $('.toggle-status-btn').click(function() {
    const btn = $(this);
    const id = btn.data('id');
    const currentStatus = btn.data('status'); // FIX
    const newStatus = currentStatus == 1 ? 0 : 1;

    $.ajax({
      url: 'toggle_status.php',
      method: 'POST',
      data: { id: id, status: newStatus },
      success: function(response) {
        if(response == 'success') {
          btn.data('status_aktif', newStatus); // FIX
          if(newStatus == 1) {
            btn.removeClass('btn-secondary').addClass('btn-success').text('Aktif');
          } else {
            btn.removeClass('btn-success').addClass('btn-secondary').text('Nonaktif');
          }
        } else {
          alert('Gagal mengubah status.');
        }
      },
      error: function() {
        alert('Terjadi kesalahan saat menghubungi server.');
      }
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const tambahModal = document.getElementById('modalTambah');

    // Reset form dan fokus ke input saat modal tambah dibuka
    tambahModal.addEventListener('show.bs.modal', function () {
      const form = tambahModal.querySelector('form');
      form.reset();
      setTimeout(() => {
        form.querySelector('[name="nama_kriteria"]').focus();
      }, 300);
    });

    // Validasi bobot pada form tambah dan edit (prevent angka negatif)
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function (e) {
        const bobotAtasan = form.querySelector('[name="bobot_atasan"]');
        const bobotRekan = form.querySelector('[name="bobot_rekan"]');
        
        if (bobotAtasan.value < 0 || bobotRekan.value < 0) {
          e.preventDefault();
          alert('Bobot tidak boleh bernilai negatif.');
        }
      });
    });
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
