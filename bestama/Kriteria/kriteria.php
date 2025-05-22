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
  <!-- <link rel='stylesheet' type='text/css' media='screen' href='main.css'> -->
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
                  <?php while ($row = mysqli_fetch_assoc($result)): 
                    if ($row['bobot_atasan'] > 0):
                      $statusLabel = $row['status_aktif'] ? 'Aktif' : 'Nonaktif';
                      $btnClass = $row['status_aktif'] ? 'btn-danger' : 'btn-success';
                      $nextStatus = $row['status_aktif'] ? 0 : 1;
                      $labelTombol = $row['status_aktif'] ? 'Nonaktifkan' : 'Aktifkan';
                  ?>
                    <tr>
                      <td><?= $row['id_kriteria'] ?></td>
                      <td><?= $row['nama_kriteria'] ?></td>
                      <td class='text-center'><?= $row['bobot_atasan'] ?>%</td>
                      <td class='text-center'><?= $row['bobot_rekan'] ?>%</td>
                      <td class='text-center'><?= $statusLabel ?></td>
                      <td class='text-center'>
                      <button 
                        class='btn btn-sm toggle-status-btn <?= $btnClass ?>' 
                        data-id_kriteria='<?= $row['id_kriteria'] ?>' 
                        data-status='<?= $row['status_aktif'] ?>'>
                        <?= $labelTombol ?>
                      </button>
                        <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#modalEdit<?= $row['id_kriteria'] ?>'>
                          Edit
                        </button>
                      </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEdit<?= $row['id_kriteria'] ?>" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="edit_kriteria.php" method="post" class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Kriteria</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                             <input type="hidden" name="id_kriteria" value="<?= $row['id_kriteria'] ?>">
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
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  <?php 
                    endif;
                  endwhile; 
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
      <form action="tambah_kriteria.php" method="post" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kriteria</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Id Kriteria</label>
            <input type="text" name="nama_kriteria" class="form-control" required>
          </div>
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

  <!-- jQuery harus lebih dahulu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function () {
    $('.toggle-status-btn').click(function () {
      const btn = $(this);
      const id = btn.data('id_kriteria'); // ← sesuaikan atribut HTML-nya
      const currentStatus = btn.data('status');
      const newStatus = currentStatus == 1 ? 0 : 1;

      btn.prop('disabled', true); // cegah klik ganda

      $.ajax({
        url: 'toggle_status.php',
        method: 'POST',
        data: {
          id_kriteria: id,
          status_aktif: newStatus
        },
        success: function (response) {
          if (response.trim() === 'success') {
            btn.data('status', newStatus);
            btn.toggleClass('btn-success btn-danger');
            btn.text(newStatus == 1 ? 'Nonaktifkan' : 'Aktifkan');
            btn.closest('tr').find('td:nth-child(5)').text(newStatus == 1 ? 'Aktif' : 'Nonaktif');
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

    // Reset form tambah saat modal dibuka
    const tambahModal = document.getElementById('modalTambah');
    if (tambahModal) {
      tambahModal.addEventListener('show.bs.modal', function () {
        const form = tambahModal.querySelector('form');
        form.reset();
        setTimeout(() => {
          form.querySelector('[name="nama_kriteria"]').focus();
        }, 300);
      });
    }

    // Validasi bobot tidak negatif atau >100
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function (e) {
        const bAtasan = form.querySelector('[name="bobot_atasan"]');
        const bRekan = form.querySelector('[name="bobot_rekan"]');
        if (!bAtasan || !bRekan) return;

        const atasanVal = parseFloat(bAtasan.value);
        const rekanVal = parseFloat(bRekan.value);

        if (atasanVal < 0 || rekanVal < 0) {
          e.preventDefault();
          alert('Bobot tidak boleh negatif.');
        } else if (atasanVal > 100 || rekanVal > 100) {
          e.preventDefault();
          alert('Bobot tidak boleh lebih dari 100%.');
        }
      });
    });
  });
</script>

</body>
</html>