<?php
include 'db.php';
session_start();
header('Content-Type: application/json');
if(($_SESSION['role'] ?? '') != 'admin'){
    echo json_encode(['error'=>'Unauthorized']);
    exit;
}
$id = $_POST['id'];
$conn->query("DELETE FROM products WHERE id=$id");
echo json_encode(['success'=>true]);
?>