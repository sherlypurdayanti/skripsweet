<?php
include '../../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip_lama = $_POST['nip_lama'];
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $jabatan = $_POST['jabatan'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $status = $_POST['status'];
    $perusahaan = $_POST['perusahaan'];

    $query = "UPDATE tabel_karyawan SET 
                nip = ?, 
                nama = ?, 
                bagian = ?, 
                jabatan = ?,
                tanggal_masuk = ?,
                `status` = ?,
                perusahaan = ?
              WHERE nip = ?";

    $stmt = mysqli_prepare($koneksi, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $nip, $nama, $bagian, $jabatan, $tanggal_masuk, $status, $perusahaan, $nip_lama);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            echo "<script>
                    alert('Data karyawan berhasil diperbarui!');
                    window.location.href = 'karyawan.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal memperbarui data.');
                    window.history.back();
                  </script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>
                alert('Terjadi kesalahan pada query.');
                window.history.back();
              </script>";
    }
}

mysqli_close($koneksi);
?>
