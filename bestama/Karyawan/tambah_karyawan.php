<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jk = $_POST['jenis_kelamin'];
    $bagian = $_POST['bagian'];
    $jabatan = $_POST['jabatan'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $status = $_POST['status'];
    $perusahaan = 'PT. Berkah Sejahtera Investama';

    $username = $_POST['username'];
    $password = $_POST['password']; // plain password dari form
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // hash dengan bcrypt
    $role = 'karyawan'; // atau sesuaikan logika role-nya

    // Insert ke tabel_karyawan
    $query_karyawan = "INSERT INTO tabel_karyawan (nip, nama, jenis_kelamin, bagian, jabatan, tanggal_masuk, `status`, perusahaan) 
                   VALUES ('$nip', '$nama', '$jk', '$bagian', '$jabatan', '$tanggal_masuk', '$status', '$perusahaan')";

    // Insert ke users
    $query_users = "INSERT INTO users (nip, username, password, role) 
                    VALUES ('$nip', '$username', '$hashed_password', '$role')";

    // Eksekusi keduanya
    $insert_karyawan = mysqli_query($koneksi, $query_karyawan);
    $insert_user = mysqli_query($koneksi, $query_users);

    if ($insert_karyawan && $insert_user) {
        echo "<script>alert('Data karyawan dan user berhasil ditambahkan'); window.location.href='karyawan.php';</script>";
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
}
?>
