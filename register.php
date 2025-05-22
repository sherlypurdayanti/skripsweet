<?php
session_start();
include 'config/koneksi.php'; // pastikan koneksi sudah benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nip = htmlspecialchars($_POST['nip']);
  $username = htmlspecialchars($_POST['username']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = htmlspecialchars($_POST['role']);
  $created_at = date('Y-m-d H:i:s');

  // Cek apakah username sudah ada
  $cek = $koneksi->prepare("SELECT nip FROM users WHERE username = ?");
  $cek->bind_param("s", $username);
  $cek->execute();
  $result = $cek->get_result();

  if ($result->num_rows > 0) {
    echo "<script>alert('Username sudah digunakan!'); window.location.href='register.php';</script>";
    exit;
  }

  // Simpan ke database
  $stmt = $koneksi->prepare("INSERT INTO users (nip, username, password, role, created_at) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $nip, $username, $password, $role, $created_at);

  if ($stmt->execute()) {
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='index.php';</script>";
  } else {
    echo "<script>alert('Registrasi gagal!'); window.location.href='register.php';</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi | Aplikasi Anda</title>
  <link rel="stylesheet" href="style.css">
</head>
<style>
  body {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', sans-serif;
  }

  .register-box {
    background-color: #fff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
  }

  .register-box h2 {
    margin-bottom: 24px;
    text-align: center;
    color: #333;
  }

  .input-group {
    margin-bottom: 16px;
  }

  .input-group label {
    display: block;
    margin-bottom: 6px;
    color: #555;
  }

  .input-group input,
  .input-group select {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
  }

  button {
    width: 100%;
    padding: 12px;
    background-color: #2575fc;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
  }

  button:hover {
    background-color: #1a5edb;
  }

  .back-login {
    text-align: center;
    margin-top: 16px;
    font-size: 14px;
  }
</style>

<body>
  <div class="register-box">
    <h2>Form Registrasi</h2>
    <form method="POST" action="">
      <div class="input-group">
        <label for="nip">NIP</label>
        <input type="text" name="nip" id="nip" required>
      </div>
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
      </div>
      <div class="input-group">
        <label for="role">Role</label>
        <select name="role" id="role" required>
        <option value="" disabled selected>-- Pilih Role --</option>
          <option value="admin">ADMIN</option>
          <option value="karyawan">KARYAWAN</option>
          <option value="manager_bagian">MANAGER BAGIAN</option>
          <option value="hrd_tgm">HRD TGM</option>
          <option value="hrd_bestama">HRD BESTAMA</option>
          <option value="hrd_wisyam">HRD WISYAM</option>
          <option value="hrd_foleya">HRD FOLEYA</option>
          <option value="hrd_karis">HRD KARIS</option>
          <option value="manager_hrd">MANAGER HRD</option>
        </select>
      </div>
      <button type="submit">Daftar</button>
    </form>
    <div class="back-login">
      Sudah punya akun? <a href="index.php" style="color: #2575fc;">Login di sini</a>
    </div>
  </div>
</body>

</html>
