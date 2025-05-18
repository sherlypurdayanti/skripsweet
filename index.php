<?php
session_start();
include 'config/koneksi.php'; // pastikan file koneksi benar

// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
  header('Location: dashboard.php'); // Ubah sesuai kebutuhan
  exit;
}

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = htmlspecialchars($_POST['username']);
  $password = $_POST['password'];

  // Gunakan prepared statement untuk keamanan
  $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();

  $result = $stmt->get_result();

  // Cek jika user ditemukan
  if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $data['password'])) {
      // Simpan data ke session
      $_SESSION['username'] = $data['username'];
      $_SESSION['role'] = $data['role'];
      $_SESSION['nip'] = $data['nip'];

      // Redirect berdasarkan role
      switch ($data['role']) {
        case 'hrd_tgm':
          header('Location: tgm/dashboard.php');
          break;
        case 'hrd_bestama':
          header('Location: bestama/dashboard.php');
          break;
        case 'hrd_karis':
          header('Location: karis/dashboard.php');
          break;
        case 'hrd_foleya':
          header('Location: foleya/dashboard.php');
          break;
        case 'hrd_wisyam':
          header('Location: wisyam/dashboard.php');
          break;
        case 'manager_hrd':
          header('Location: manager/dashboard.php');
          break;
        case 'direktur_utama':
          header('Location: direktur/dashboard.php');
          break;
        default:
          header('Location: default_dashboard.php');
      }
      exit;
    } else {
      echo "<script>alert('Password salah!'); window.location.href='index.php';</script>";
    }
  } else {
    echo "<script>alert('Username tidak ditemukan!'); window.location.href='login.php';</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Aplikasi Anda</title>
  <link rel="stylesheet" href="style.css">
</head>
<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  body {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    padding: 20px;
  }

  .login-box {
    background-color: #fff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
  }

  .login-box h2 {
    margin-bottom: 24px;
    color: #333;
  }

  .input-group {
    margin-bottom: 20px;
    text-align: left;
  }

  .input-group label {
    display: block;
    margin-bottom: 6px;
    color: #555;
  }

  .input-group input {
    width: 100%;
    padding: 10px 14px;
    border-radius: 6px;
    border: 1px solid #ccc;
    transition: 0.3s;
  }

  .input-group input:focus {
    border-color: #2575fc;
    outline: none;
  }

  button {
    width: 100%;
    padding: 12px;
    background-color: #2575fc;
    border: none;
    border-radius: 6px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
  }

  button:hover {
    background-color: #1a5edb;
  }
</style>

<body>
  <div class="login-container">
    <div class="login-box">
      <h2>Selamat Datang!</h2>
      <form method="POST" action="">
        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Masukkan username" required>
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</body>

</html>