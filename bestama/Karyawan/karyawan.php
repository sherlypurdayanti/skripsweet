<?php
include '../../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
  <style>
    .btn-custom {
        background-color: #063970;
        color: white;
        padding : 10px;
        margin : 10px;
        border: none;
    }
    .bg-custom {
      background-color: #044885 !important;
      color: white !important;
    }

  </style>

<?php include "../sidebar.php" ?>

<!-- Konten -->
<div class="content" id="content">
  <div class="card shadow-sm mt-4">
    <div class="card-header bg-custom">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0">Data Hasil Penilaian</h5>
        <div class="d-flex align-items-center gap-2">
          <input type="text" class="form-control" placeholder="Cari nama..." id="searchNama" style="width: 200px;">
          <select class="form-select" id="filterPerusahaan" style="width: 200px;">
            <option value="">-- Filter Perusahaan --</option>
            <?php
              $perusahaan_query = mysqli_query($koneksi, "SELECT DISTINCT perusahaan FROM tabel_karyawan");
              while ($p = mysqli_fetch_assoc($perusahaan_query)) {
                echo '<option value="' . htmlspecialchars($p['perusahaan'], ENT_QUOTES) . '">' . htmlspecialchars($p['perusahaan']) . '</option>';
              }
            ?>
          </select>
          <button class="btn btn-light" type="button" onclick="filterData()">Cari</button>
        </div>
      </div>
    </div>
  <div class="card-body">
    <!-- Tombol Tambah Karyawan -->
    <div class="d-flex justify-content-start mb-2">
      <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahKaryawan">
        Tambah Data Karyawan
      </button>
    </div>

    <!-- Tabel Karyawan -->
    <table id="tabelKaryawan" class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th class="text-center fw-bold">No</th>
          <th class="text-center fw-bold">NIP</th>
          <th class="text-center fw-bold">Nama</th>
          <th class="text-center fw-bold">Bagian</th>
          <th class="text-center fw-bold">Perusahaan</th>
          <th class="text-center fw-bold">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM tabel_karyawan");
        $no = 1;
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td class="text-center"><?= htmlspecialchars($row['nip']) ?></td>
            <td>
              <a href="../Penilaian/detail_penilaian.php?nip=<?= urlencode($row['nip']) ?>">
                <?= htmlspecialchars($row['nama']) ?>
              </a>
            </td>
            <td><?= htmlspecialchars($row['bagian']) ?></td>
            <td><?= htmlspecialchars($row['perusahaan']) ?></td>
            <td class="text-center">
              <button class="btn btn-info" onclick="showDetailKaryawan(
                '<?= htmlspecialchars($row['nip'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['bagian'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['jabatan'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['tanggal_masuk'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['status'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['perusahaan'], ENT_QUOTES) ?>')">
                <i class="bi bi-eye"></i>
              </button>

              <button class="btn btn-sm btn-warning text-white" onclick="showEditModal(
                '<?= htmlspecialchars($row['nip'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['bagian'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['jabatan'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['tanggal_masuk'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['status'], ENT_QUOTES) ?>',
                '<?= htmlspecialchars($row['perusahaan'], ENT_QUOTES) ?>')">
                <i class="bi bi-pencil-square"></i>
              </button>

              <a href="hapus_karyawan.php?nip=<?= urlencode($row['nip']) ?>"
                 onclick="return confirm('Yakin ingin menghapus data karyawan ini?')"
                 class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

  <!-- Modal Tambah Data Karyawan -->
  <div class="modal fade" id="modalTambahKaryawan" tabindex="-1" aria-labelledby="modalTambahKaryawanLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="tambah_karyawan.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahKaryawanLabel">Form Tambah Data Karyawan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">

            <div class="mb-3">
              <label for="nip" class="form-label">NIP</label>
              <input type="text" class="form-control" id="nip" name="nip" required>
            </div>

            <div class="mb-3">
              <label for="nama" class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
              <label for="bagian" class="form-label">Bagian</label>
              <input type="text" class="form-control" id="bagian" name="bagian" required>
            </div>

            <div class="mb-3">
              <label for="jabatan" class="form-label">Jabatan</label>
              <input type="text" class="form-control" id="jabatan" name="jabatan" required>
            </div>

            <div class="mb-3">
              <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
              <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
            </div>

            <div class="mb-3">
              <label for="status_karyawan" class="form-label">Status Karyawan</label>
              <select class="form-control" id="status_karyawan" name="status_karyawan" required>
                <option value="">-- Pilih Status --</option>
                <option value="Tetap">Tetap</option>
                <option value="Kontrak">Kontrak</option>
                <option value="Magang">Magang</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="perusahaan" class="form-label">Perusahaan</label>
              <input type="text" class="form-control" id="perusahaan" name="perusahaan" required>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Detail Karyawan -->
  <div class="modal fade" id="modalDetailKaryawan" tabindex="-1" aria-labelledby="modalDetailKaryawanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailKaryawanLabel">Detail Data Karyawan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <form id="formDetailKaryawan">
          <div class="mb-3">
            <label for="detailNip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="detailNip" disabled>
          </div>
          <div class="mb-3">
            <label for="detailNama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="detailNama" disabled>
          </div>
          <div class="mb-3">
            <label for="detailBagian" class="form-label">Bagian</label>
            <input type="text" class="form-control" id="detailBagian" disabled>
          </div>
          <div class="mb-3">
            <label for="detailJabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="detailJabatan" disabled>
          </div>
          <div class="mb-3">
            <label for="detailTanggalMasuk" class="form-label">Tanggal Masuk</label>
            <input type="date" class="form-control" id="detailTanggalMasuk" disabled>
          </div>
          <div class="mb-3">
            <label for="detailStatus" class="form-label">Status</label>
            <input type="text" class="form-control" id="detailStatus" disabled>
          </div>
          <div class="mb-3">
            <label for="detailPerusahaan" class="form-label">Perusahaan</label>
            <input type="text" class="form-control" id="detailPerusahaan" disabled>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

  <!-- Modal Edit Data Karyawan -->
  <div class="modal fade" id="modalEditKaryawan" tabindex="-1" aria-labelledby="modalEditKaryawanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="edit_karyawan.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditKaryawanLabel">Form Edit Data Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="editNipLama" name="nip_lama">

          <div class="mb-3">
            <label for="editNip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="editNip" name="nip" required>
          </div>

          <div class="mb-3">
            <label for="editNama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="editNama" name="nama" required>
          </div>

          <div class="mb-3">
            <label for="editBagian" class="form-label">Bagian</label>
            <input type="text" class="form-control" id="editBagian" name="bagian" required>
          </div>

          <div class="mb-3">
            <label for="editJabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="editJabatan" name="jabatan" required>
          </div>

          <div class="mb-3">
            <label for="editTanggalMasuk" class="form-label">Tanggal Masuk</label>
            <input type="date" class="form-control" id="editTanggalMasuk" name="tanggal_masuk" required>
          </div>

          <div class="mb-3">
            <label for="editStatus" class="form-label">Status Karyawan</label>
            <select class="form-control" id="editStatus" name="status" required>
              <option value="">-- Pilih Status --</option>
              <option value="Tetap">Tetap</option>
              <option value="Kontrak">Kontrak</option>
              <option value="Magang">Magang</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="editPerusahaan" class="form-label">Perusahaan</label>
            <input type="text" class="form-control" id="editPerusahaan" name="perusahaan" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function showEditModal(nip, nama, bagian, jabatan, tanggal_masuk, status, perusahaan) {
    document.getElementById('editNipLama').value = nip;
    document.getElementById('editNip').value = nip;
    document.getElementById('editNama').value = nama;
    document.getElementById('editBagian').value = bagian;
    document.getElementById('editJabatan').value = jabatan;
    document.getElementById('editTanggalMasuk').value = tanggal_masuk;
    document.getElementById('editStatus').value = status;
    document.getElementById('editPerusahaan').value = perusahaan;

    const editModal = new bootstrap.Modal(document.getElementById('modalEditKaryawan'));
    editModal.show();
  }

  function showDetailKaryawan(nip, nama, bagian, jabatan, tanggalMasuk, status, perusahaan) {
    document.getElementById("detailNip").value = nip;
    document.getElementById("detailNama").value = nama;
    document.getElementById("detailBagian").value = bagian;
    document.getElementById("detailJabatan").value = jabatan;
    document.getElementById("detailTanggalMasuk").value = tanggalMasuk;
    document.getElementById("detailStatus").value = status;
    document.getElementById("detailPerusahaan").value = perusahaan;

    const modal = new bootstrap.Modal(document.getElementById('modalDetailKaryawan'));
    modal.show();
  }

  document.addEventListener("DOMContentLoaded", function () {
    const filterSelect = document.getElementById("filterPerusahaan");
    const searchInput = document.getElementById("searchNama");

    filterSelect.addEventListener("change", filterTable);
    searchInput.addEventListener("keyup", filterTable);

    function filterTable() {
      const perusahaanFilter = filterSelect.value.toLowerCase();
      const namaFilter = searchInput.value.toLowerCase();
      const rows = document.querySelectorAll("#tabelKaryawan tbody tr");

      rows.forEach(row => {
        const nama = row.cells[2].innerText.toLowerCase();        // Kolom Nama
        const perusahaan = row.cells[4].innerText.toLowerCase();  // Kolom Perusahaan

        const matchNama = nama.includes(namaFilter);
        const matchPerusahaan = perusahaan.includes(perusahaanFilter);

        row.style.display = (matchNama && (perusahaanFilter === "" || matchPerusahaan)) ? "" : "none";
      });
    }
  });
</script>

</body>
</html>




    