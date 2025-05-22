<?php
include '../config/koneksi.php';

// Fungsi ambil nilai enum
function getEnumValues($koneksi, $table, $column) {
    $result = $koneksi->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    $row = $result->fetch_assoc();
    preg_match("/^enum\((.*)\)$/", $row['Type'], $matches);
    $enum = explode(",", str_replace("'", "", $matches[1]));
    return $enum;
}

// Ambil enum nama_periode
$nama_periode_options = getEnumValues($koneksi, 'periode_penilaian', 'nama_periode');

$message = "";

// Proses form simpan periode
if (isset($_POST['save_periode'])) {
    $nama_periode = $_POST['nama_periode'];
    $tahun = $_POST['tahun'];
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'];

    $stmt = $koneksi->prepare("INSERT INTO periode_penilaian (nama_periode, tahun, tanggal_mulai, tanggal_selesai) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama_periode, $tahun, $tgl_mulai, $tgl_selesai);
    $stmt->execute();
    $stmt->close();
    $message = "<p class='text-success'>Periode Penilaian berhasil disimpan.</p>";
}
// Ambil periode dari database (untuk daftar periode)
$periode_options = [];
$res_periode = $koneksi->query("SELECT * FROM periode_penilaian ORDER BY tahun DESC");
while ($p = $res_periode->fetch_assoc()) {
    $periode_options[] = [
        'id_periode' => $p['id_periode'],
        'label' => $p['nama_periode'] . ' (' . $p['tahun'] . ')'
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Admin Penilaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f1f4f9; }
        #content { margin-left: 250px; padding: 20px; }
        .card { margin-bottom: 30px; }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

<div id="content" class="container-fluid">
    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <!-- Form tambah periode penilaian -->
    <div class="card">
        <div class="card-header bg-primary text-white">Tambah Periode Penilaian</div>
        <div class="card-body">
            <form method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <label>Nama Periode</label>
                        <select name="nama_periode" class="form-select" required>
                            <option value="">-- Pilih Periode --</option>
                            <?php foreach ($nama_periode_options as $val): ?>
                                <option value="<?= htmlspecialchars($val) ?>"><?= htmlspecialchars($val) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Tahun</label>
                        <select name="tahun" class="form-select" required>
                            <?php for ($i = date("Y") - 5; $i <= date("Y") + 1; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" readonly required>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" readonly required>
                    </div>
                </div>
                <button type="submit" name="save_periode" class="btn btn-success mt-3">Simpan Periode</button>
            </form>
        </div>
    </div>

    <!-- Daftar periode penilaian -->
    <?php if (!empty($periode_options)): ?>
    <div class="card">
        <div class="card-header bg-info text-white">Daftar Periode Penilaian</div>
        <div class="card-body">
            <ul class="list-group">
                <?php foreach ($periode_options as $periode): ?>
                    <li class="list-group-item"><?= htmlspecialchars($periode['label']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tahunSelect = document.querySelector('select[name="tahun"]');
        const tglMulai = document.querySelector('input[name="tanggal_mulai"]');
        const tglSelesai = document.querySelector('input[name="tanggal_selesai"]');

        function setTanggalByTahun(tahun) {
            tglMulai.value = `${tahun}-01-01`;
            tglSelesai.value = `${tahun}-12-31`;
        }

        // Atur tanggal berdasarkan tahun saat halaman pertama kali dimuat
        if (tahunSelect) {
            setTanggalByTahun(tahunSelect.value);

            tahunSelect.addEventListener('change', function () {
                setTanggalByTahun(this.value);
            });
        }
    });
</script>
</body>
</html>
