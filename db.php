<?php
$host = "localhost"; // Nama host untuk server database MySQL
$user = "root";      // Username untuk login ke MySQL
$pass = "";          // Password untuk user "root" (kosong untuk XAMPP default)
$db   = "accu_app";  // Nama database yang ingin diakses

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Tampilkan pesan jika koneksi gagal
}
?>