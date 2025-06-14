<?php
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($user_id == 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT o.id, o.user_id, o.address, o.product_id, o.qty, o.total_price, o.status,
               p.name AS product_name,
               b.alasan AS alasan_batal
        FROM orders o
        INNER JOIN products p ON o.product_id = p.id
        LEFT JOIN pembatalan b ON o.id = b.order_id
        WHERE o.user_id = ?
        ORDER BY o.id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
echo json_encode($orders);

$conn->close();
?>