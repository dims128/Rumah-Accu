<?php
include 'db.php';
session_start();
$_SESSION['role'] = 'admin'; // Set saat login berhasil
error_log('Role: ' . ($_SESSION['role'] ?? 'null'));
if(($_SESSION['role'] ?? '') != 'admin'){
    echo json_encode(['error'=>'Unauthorized']);
    exit;
}
$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$category = $_POST['category'];
$description = $_POST['description'];
$image = $_POST['image'];
$stmt = $conn->prepare("UPDATE products SET name=?, price=?, stock=?, category=?, description=?, image=? WHERE id=?");
$stmt->bind_param("sdisssi", $name, $price, $stock, $category, $description, $image, $id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to update product']);
}
$stmt->close();
if (!isset($id, $name, $price, $stock, $category) || empty($id) || empty($name)) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}
?>