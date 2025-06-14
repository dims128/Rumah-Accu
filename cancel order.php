<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

$order_id = $_POST['order_id'];
$reason = $_POST['reason'];
$user_id = $_SESSION['user_id'] ?? 0;

// Pastikan pesanan milik user
$conn->query("UPDATE orders SET status='cancelled', cancel_reason='$reason' WHERE id=$order_id AND user_id=$user_id");
echo json_encode(['success'=>true]);
?>