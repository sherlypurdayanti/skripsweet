<?php
// Mulai session untuk menangani login
session_start();

// Pastikan koneksi ke database sudah dilakukan
include 'config/koneksi.php'; // Sesuaikan dengan path file koneksi

// Cek apakah form telah disubmit
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Query untuk memeriksa data login
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    // Jika data ditemukan
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        
        // Memeriksa apakah password cocok
        if (password_verify($password, $data['password'])) {
            // Menyimpan informasi pengguna dalam session
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];  // Menyimpan role pengguna
            $_SESSION['nip'] = $data['nip'];    // Menyimpan NIP pengguna

            // Mengarahkan pengguna ke halaman yang sesuai berdasarkan role
            if ($data['role'] == 'hrd_tgm') {
                header('Location: tgm/dashboard.php');
            } elseif ($data['role'] == 'hrd_bestama') {
                header('Location: bestama/dashboard.php');
            } elseif ($data['role'] == 'hrd_karis') {
                header('Location: karis/dashboard.php');
            } elseif ($data['role'] == 'hrd_foleya') {
                header('Location: foleya/dashboard.php');
            } elseif ($data['role'] == 'hrd_wisyam') {
                header('Location: wisyam/dashboard.php');
            } elseif ($data['role'] == 'manager_hrd') {
                header('Location: manager/dashboard.php');
            } elseif ($data['role'] == 'direktur_utama') {
                header('Location: direktur/dashboard.php');
            } else {
                header('Location: default_dashboard.php'); // default jika role tidak terdaftar
            }
            exit(); // Menghentikan eksekusi lebih lanjut setelah redirect
        } else {
            // Jika password tidak cocok
            echo "<script>alert('Password salah!'); window.location.href='login.php';</script>";
        }
    } else {
        // Jika username tidak ditemukan
        echo "<script>alert('Username tidak ditemukan!'); window.location.href='../index.php';</script>";
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
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
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
