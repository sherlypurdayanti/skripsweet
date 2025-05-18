<?php
include 'config/koneksi.php'; // sambungkan ke database

// Ambil semua user dan password sekarang (yang masih plain text)
$sql = "SELECT id, password FROM users";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $plain_pass = $row['password'];

        // Cek dulu apakah password sudah hash atau belum
        // password hash biasanya panjangnya > 60 karakter dan ada prefix $2y$ atau $argon2i$ dll
        if (strlen($plain_pass) < 60) {
            // Password belum hashed, hash dulu
            $hashed_pass = password_hash($plain_pass, PASSWORD_DEFAULT);

            // Update ke database
            $update_stmt = $koneksi->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $hashed_pass, $id);
            $update_stmt->execute();

            echo "Password user ID $id sudah di-hash dan diupdate.<br>";
        } else {
            echo "Password user ID $id sudah hashed, dilewati.<br>";
        }
    }
} else {
    echo "Tidak ada user ditemukan.";
}
?>
