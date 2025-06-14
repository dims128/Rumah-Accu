<?php
include 'db.php'; // Pastikan file koneksi database disertakan
header('Content-Type: application/json');

// Query untuk mendapatkan akun admin
$sql = "SELECT id, username, password FROM users WHERE role = 'admin'";
$result = $conn->query($sql);

$admins = [];
while ($row = $result->fetch_assoc()) {
    $admins[] = $row; // Menyimpan semua data admin, termasuk password plaintext
}

// Kembalikan data dalam format JSON
echo json_encode($admins);
?>