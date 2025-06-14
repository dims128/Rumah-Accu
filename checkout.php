<?php
header('Content-Type: application/json');
require 'db.php'; // koneksi ke database

// Gunakan isset agar tidak error notice
$user_id      = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$product_id   = isset($_POST['product_id']) ? $_POST['product_id'] : null;
$qty          = isset($_POST['qty']) ? $_POST['qty'] : null;
$total_price  = isset($_POST['total_price']) ? $_POST['total_price'] : null;
$address      = isset($_POST['address']) ? $_POST['address'] : null;
$status       = isset($_POST['status']) ? $_POST['status'] : 'pending';

if (!$user_id || !$product_id || !$qty || !$total_price || !$address) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap', 'debug' => $_POST]);
    exit;
}

$query = "INSERT INTO orders (user_id, product_id, qty, total_price, address, status)
          VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param("iiidss", $user_id, $product_id, $qty, $total_price, $address, $status);

if ($stmt->execute()) {
    $order_id = $conn->insert_id;
    echo json_encode(['success' => true, 'order_id' => $order_id]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
?>