<?php
include 'db.php';
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['message' => 'Username dan password diperlukan']);
    exit;
}

// Jika id kosong, berarti tambah admin
if (empty($id)) {
    $hashedPassword = $password; // Simpan password langsung tanpa hash
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
    $stmt->bind_param("ss", $username, $hashedPassword);
} else {
    // Update admin
    $hashedPassword = $password; // Simpan password langsung tanpa hash
    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $hashedPassword, $id);
}

if ($stmt->execute()) {
    echo json_encode(['message' => 'Admin berhasil disimpan']);
} else {
    echo json_encode(['message' => 'Gagal menyimpan admin']);
}
?>