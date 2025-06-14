<?php
include 'db.php'; // Pastikan koneksi database sudah benar

header('Content-Type: application/json');

// Ambil data dari POST request
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['order_id'], $data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    http_response_code(400);
    exit;
}

$order_id = $data['order_id'];
$status = $data['status'];

// Query untuk memperbarui status pesanan
$sql = "UPDATE orders SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Gagal menyiapkan statement: ' . $conn->error]);
    http_response_code(500);
    exit;
}

$stmt->bind_param('si', $status, $order_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Status pesanan berhasil diperbarui']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status pesanan: ' . $stmt->error]);
    http_response_code(500);
}

$stmt->close();
$conn->close();
?>