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

// Proses simpan kriteria & sub_kriteria (dari kode kedua) — menggunakan tombol bernama 'save_kriteria'
if (isset($_POST['save_kriteria'])) {
    // Reset semua dulu
    $koneksi->query("UPDATE kriteria SET status_aktif = 0, untuk_atasan = 0, untuk_rekan = 0");
    $koneksi->query("UPDATE sub_kriteria SET status_aktif = 0, untuk_atasan = 0, untuk_rekan = 0");

    // Update kriteria
    if (!empty($_POST['kriteria_aktif'])) {
        $ids = array_map('intval', $_POST['kriteria_aktif']);
        $koneksi->query("UPDATE kriteria SET status_aktif = 1 WHERE id IN (" . implode(',', $ids) . ")");
    }
    if (!empty($_POST['kriteria_atasan'])) {
        $ids = array_map('intval', $_POST['kriteria_atasan']);
        $koneksi->query("UPDATE kriteria SET untuk_atasan = 1 WHERE id IN (" . implode(',', $ids) . ")");
    }
    if (!empty($_POST['kriteria_rekan'])) {
        $ids = array_map('intval', $_POST['kriteria_rekan']);
        $koneksi->query("UPDATE kriteria SET untuk_rekan = 1 WHERE id IN (" . implode(',', $ids) . ")");
    }

    // Update sub_kriteria
    if (!empty($_POST['sub_aktif'])) {
        $ids = array_map('intval', $_POST['sub_aktif']);
        $koneksi->query("UPDATE sub_kriteria SET status_aktif = 1 WHERE id IN (" . implode(',', $ids) . ")");
    }
    if (!empty($_POST['sub_atasan'])) {
        $ids = array_map('intval', $_POST['sub_atasan']);
        $koneksi->query("UPDATE sub_kriteria SET untuk_atasan = 1 WHERE id IN (" . implode(',', $ids) . ")");
    }
    if (!empty($_POST['sub_rekan'])) {
        $ids = array_map('intval', $_POST['sub_rekan']);
        $koneksi->query("UPDATE sub_kriteria SET untuk_rekan = 1 WHERE id IN (" . implode(',', $ids) . ")");
    }

    $message = "<p class='text-success'>Kriteria & Sub-Kriteria berhasil disimpan.</p>";
}

// Ambil data kriteria dan sub_kriteria untuk form kelola
$kriteria_data = [];
$res = $koneksi->query("SELECT * FROM kriteria ORDER BY id");
while ($k = $res->fetch_assoc()) {
    $kriteria_data[$k['id']] = [
        'id' => $k['id'],
        'nama' => $k['nama_kriteria'],
        'status_aktif' => $k['status_aktif'],
        'untuk_atasan' => $k['untuk_atasan'],
        'untuk_rekan' => $k['untuk_rekan'],
        'sub_kriteria' => []
    ];
}

$res2 = $koneksi->query("SELECT * FROM sub_kriteria ORDER BY id");
while ($s = $res2->fetch_assoc()) {
    if (isset($kriteria_data[$s['kriteria_id']])) {
        $kriteria_data[$s['kriteria_id']]['sub_kriteria'][] = [
            'id' => $s['id'],
            'nama' => $s['nama_sub_kriteria'],
            'status_aktif' => $s['status_aktif'],
            'untuk_atasan' => $s['untuk_atasan'],
            'untuk_rekan' => $s['untuk_rekan']
        ];
    }
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

    <!-- Form kelola kriteria & sub-kriteria -->
    <div class="card">
        <div class="card-header bg-secondary text-white">Kelola Kriteria & Sub-Kriteria</div>
        <div class="card-body">
            <form method="POST">
                <?php foreach ($kriteria_data as $k): ?>
                <div class="mb-3 p-3 border rounded bg-light">
                    <div>
                        <label>
                            <input type="checkbox" name="kriteria_aktif[]" value="<?= $k['id'] ?>" <?= $k['status_aktif'] ? 'checked' : '' ?>>
                            <strong><?= htmlspecialchars($k['nama']) ?></strong>
                        </label>
                        &nbsp;&nbsp;&nbsp;
                        <label>
                            <input type="checkbox" name="kriteria_atasan[]" value="<?= $k['id'] ?>" <?= $k['untuk_atasan'] ? 'checked' : '' ?>>
                            Untuk Atasan
                        </label>
                        &nbsp;&nbsp;&nbsp;
                        <label>
                            <input type="checkbox" name="kriteria_rekan[]" value="<?= $k['id'] ?>" <?= $k['untuk_rekan'] ? 'checked' : '' ?>>
                            Untuk Rekan Kerja
                        </label>
                    </div>
                    <div class="ms-4 mt-2">
                        <?php foreach ($k['sub_kriteria'] as $s): ?>
                        <div>
                            <label>
                                <input type="checkbox" name="sub_aktif[]" value="<?= $s['id'] ?>" <?= $s['status_aktif'] ? 'checked' : '' ?>>
                                <?= htmlspecialchars($s['nama']) ?>
                            </label>
                            &nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="checkbox" name="sub_atasan[]" value="<?= $s['id'] ?>" <?= $s['untuk_atasan'] ? 'checked' : '' ?>>
                                Untuk Atasan
                            </label>
                            &nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="checkbox" name="sub_rekan[]" value="<?= $s['id'] ?>" <?= $s['untuk_rekan'] ? 'checked' : '' ?>>
                                Untuk Rekan Kerja
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <button type="submit" name="save_kriteria" class="btn btn-primary mt-3">Simpan Kriteria & Sub-Kriteria</button>
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
    // Optional: membuat tanggal mulai dan selesai tetap tanggal hari ini dan besok
    document.addEventListener('DOMContentLoaded', function() {
        const tglMulai = document.querySelector('input[name="tanggal_mulai"]');
        const tglSelesai = document.querySelector('input[name="tanggal_selesai"]');
        if (tglMulai && tglSelesai) {
            const today = new Date().toISOString().split('T')[0];
            tglMulai.value = today;
            // default selesai besok
            let tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            tglSelesai.value = tomorrow.toISOString().split('T')[0];
        }
    });
</script>
</body>
</html>
