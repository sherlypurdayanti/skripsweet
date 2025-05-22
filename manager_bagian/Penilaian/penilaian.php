<?php
include '../../config/koneksi.php';

$nip = isset($_GET['nip']) ? htmlspecialchars($_GET['nip']) : '';
$nama = '';
if ($nip) {
    $queryNama = mysqli_query($koneksi, "SELECT nama FROM tabel_karyawan WHERE nip = '$nip'");
    if ($data = mysqli_fetch_assoc($queryNama)) {
        $nama = $data['nama'];
    }
}

// Ambil filter dari URL
$namaFilter = isset($_GET['nama']) ? mysqli_real_escape_string($koneksi, $_GET['nama']) : '';
$perusahaanFilter = isset($_GET['perusahaan']) ? mysqli_real_escape_string($koneksi, $_GET['perusahaan']) : '';
$periodeFilter = isset($_GET['periode']) ? mysqli_real_escape_string($koneksi, $_GET['periode']) : '';

// Bangun klausa WHERE
$where = [];
if ($namaFilter) $where[] = "karyawan.nama LIKE '%$namaFilter%'";
if ($perusahaanFilter) $where[] = "karyawan.perusahaan = '$perusahaanFilter'";
if ($periodeFilter) $where[] = "penilaian.periode = '$periodeFilter'";

$where_sql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

// Query gabungan
$query = "
    SELECT penilaian.*, karyawan.nama, karyawan.perusahaan 
    FROM penilaian 
    LEFT JOIN tabel_karyawan AS karyawan ON penilaian.nip = karyawan.nip 
    $where_sql
";

// Eksekusi query
$penilaianQuery = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
$penilaianList = [];
while ($row = mysqli_fetch_assoc($penilaianQuery)) {
    $penilaianList[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Data Penilaian</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 250px;
            height: 100%;
            background-color: #1a252f;
            padding-top: 20px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        th, td {
            text-align: center;
        }
        th, .bg-custom {
            background-color: #044885 !important;
            color: white !important;
        }
    </style>
</head>
<body>

<?php include "../sidebar.php"; ?>

<div class="content">
    <?php if ($nip && $nama): ?>
        <div class="mb-4 p-3 bg-light border rounded shadow-sm">
            <h5><strong><?= htmlspecialchars($nip . ' - ' . $nama) ?></strong></h5>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-custom">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">Data Hasil Penilaian</h5>
                <div class="d-flex align-items-center gap-2">
                    <input type="text" class="form-control" placeholder="Cari nama..." id="searchNama" style="width: 200px;" value="<?= htmlspecialchars($namaFilter) ?>">
                    <select class="form-select" id="filterPerusahaan" style="width: 200px;">
                        <option value="">-- Filter Perusahaan --</option>
                        <?php
                        $perusahaan_query = mysqli_query($koneksi, "SELECT DISTINCT perusahaan FROM tabel_karyawan");
                        while ($p = mysqli_fetch_assoc($perusahaan_query)) {
                            $selected = ($p['perusahaan'] == $perusahaanFilter) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($p['perusahaan'], ENT_QUOTES) . "\" $selected>" . htmlspecialchars($p['perusahaan']) . '</option>';
                        }
                        ?>
                    </select>
                    <select class="form-select" id="filterPeriode" style="width: 200px;">
                        <option value="">-- Filter Periode --</option>
                        <?php
                        $periode_query = mysqli_query($koneksi, "SELECT DISTINCT periode FROM penilaian");
                        while ($p = mysqli_fetch_assoc($periode_query)) {
                            $selected = ($p['periode'] == $periodeFilter) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($p['periode'], ENT_QUOTES) . "\" $selected>" . htmlspecialchars($p['periode']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Perusahaan</th>
                            <th>Tahun</th>
                            <th>Periode</th>
                            <th>Penilai</th>
                            <th>ID Kriteria</th>
                            <th>ID Subkriteria</th>
                            <th>Nilai</th>
                            <th>Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($penilaianList)): ?>
                            <?php foreach ($penilaianList as $data): ?>
                                <tr>
                                    <td><?= $data['id_penilaian'] ?></td>
                                    <td><?= $data['nip'] ?></td>
                                    <td><?= $data['nama'] ?></td>
                                    <td><?= $data['perusahaan'] ?></td>
                                    <td><?= $data['tahun'] ?></td>
                                    <td><?= $data['periode'] ?></td>
                                    <td>
                                        <?php
                                        switch ($data['penilai']) {
                                            case 1: echo 'Atasan'; break;
                                            case 2: echo 'Rekan 1'; break;
                                            case 3: echo 'Rekan 2'; break;
                                            case 4: echo 'Rekan 3'; break;
                                            default: echo 'Lainnya';
                                        }
                                        ?>
                                    </td>
                                    <td><?= $data['kriteria_id'] ?></td>
                                    <td><?= $data['sub_kriteria_id'] ?></td>
                                    <td><?= $data['nilai'] ?></td>
                                    <td><?= $data['tanggal_input'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="11">Belum ada data penilaian.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function filterData() {
    const nama = document.getElementById("searchNama").value;
    const perusahaan = document.getElementById("filterPerusahaan").value;
    const periode = document.getElementById("filterPeriode").value;

    const params = new URLSearchParams({
        nama: nama,
        perusahaan: perusahaan,
        periode: periode
    });

    window.location.href = "penilaian.php?" + params.toString();
}
</script>
</body>
</html>
