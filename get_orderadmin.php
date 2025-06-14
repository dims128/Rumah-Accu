<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
include 'db.php';

$sql = "SELECT id, user_id, address, product_id, qty, total_price, status, order_date, sender_account, payment_status FROM orders ORDER BY id DESC";
$sql = "SELECT o.id, o.user_id, o.address, o.product_id, o.qty, o.total_price, o.status, o.sender_account, o.payment_status, b.alasan AS alasan_batal
FROM orders o
LEFT JOIN pembatalan b ON o.id = b.order_id
ORDER BY o.id DESC";

$result = $conn->query($sql);
$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
echo json_encode(['success' => true, 'orders' => $orders]);
?>