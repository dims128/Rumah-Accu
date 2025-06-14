<?php
include 'db.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (empty($id)) {
    echo json_encode(['message' => 'ID tidak valid']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Admin berhasil dihapus']);
} else {
    echo json_encode(['message' => 'Gagal menghapus admin']);
}
?>