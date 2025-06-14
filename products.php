<?php
include 'db.php';
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT id, name, category, description, stock, price FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Produk tidak ditemukan"]);
    }
    exit;
}

$sql = "SELECT id, name, category, description, stock, price FROM products";
$result = $conn->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
?>