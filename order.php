<?php
include 'db.php';
session_start();
header('Content-Type: application/json');
$user_id = $_SESSION['user_id'] ?? 0;
$product_id = $_POST['product_id'];
$qty = $_POST['qty'];

if(!$user_id) {
    echo json_encode(['error' => 'Anda harus login!']);
    exit;
}

$queryStock = $conn->query("SELECT stock FROM products WHERE id = $product_id");
$stock = $queryStock->fetch_assoc()['stock'];
if($qty > $stock) {
    echo json_encode(['error'=>'Stok tidak cukup']);
    exit;
}

// Kurangi stok
$conn->query("UPDATE products SET stock = stock - $qty WHERE id = $product_id");

// Tambah order
$conn->query("INSERT INTO orders (user_id, product_id, qty, status) VALUES ($user_id, $product_id, $qty, 'pending')");
echo json_encode(['success'=>true]);
?>