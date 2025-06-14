<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

if(($_SESSION['role'] ?? '') != 'admin'){
    echo json_encode(['error'=>'Unauthorized']);
    exit;
}

$name = $_POST['name'] ?? '';
$price = $_POST['price'] ?? 0;
$stock = $_POST['stock'] ?? 0;
$category = $_POST['category'] ?? 'lainnya';
$description = $_POST['description'] ?? '';
$imageName = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $imageName = uniqid() . "_" . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetDir . $imageName);
}

$stmt = $conn->prepare("INSERT INTO products (name, price, stock, category, description, picture) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("siisss", $name, $price, $stock, $category, $description, $imageName);

if($stmt->execute()){
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false, 'error'=>'Gagal menambah produk']);
}
?>
