<?php
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = htmlspecialchars($_POST['nip']);
    $password_baru = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);

    // Cek apakah NIP ada
    $cek = $koneksi->prepare("SELECT * FROM users WHERE nip = ?");
    $cek->bind_param("s", $nip);
    $cek->execute();
    $result = $cek->get_result();

    if ($result && $result->num_rows > 0) {
        // Update password
        $update = $koneksi->prepare("UPDATE users SET password = ? WHERE nip = ?");
        $update->bind_param("ss", $password_baru, $nip);
        if ($update->execute()) {
            echo "<script>alert('Password berhasil direset. Silakan login.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gagal mereset password.');</script>";
        }
    } else {
        echo "<script>alert('NIP tidak ditemukan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lupa Password</title>
</head>
<body>
  <h2>Reset Password Berdasarkan NIP</h2>
  <form method="POST" action="">
    <label for="nip">NIP:</label><br>
    <input type="text" id="nip" name="nip" required><br><br>

    <label for="password_baru">Password Baru:</label><br>
    <input type="password" id="password_baru" name="password_baru" required><br><br>

    <button type="submit">Reset Password</button>
  </form>
  <p><a href="index.php">Kembali ke Login</a></p>
</body>
</html>
