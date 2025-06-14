<?php
include 'db.php';
session_start();
header('Content-Type: application/json');
$user_id = $_SESSION['user_id'] ?? 0;

$sql = "SELECT o.*, p.name AS product_name
FROM orders o
JOIN products p ON o.product_id = p.id
WHERE o.user_id = ?
ORDER BY o.created_at DESC";
$result = $conn->query($sql);

$orders = [];
while($row = $result->fetch_assoc()){
    $orders[] = $row;
}
echo json_encode($orders);
?>