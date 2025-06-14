<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "upload_bukti.php hanya bisa dipakai dengan metode POST.";
    exit;
}


$order_id = intval($_POST['order_id'] ?? 0);
$sender_account = isset($_POST['sender_account']) ? trim($_POST['sender_account']) : '';

if ($sender_account === '' || strlen($sender_account) < 5 || !preg_match('/^[0-9 \-]+$/', $sender_account)){
    echo json_encode(['success'=>false, 'error'=>'Nomor rekening pengirim tidak valid.']);
    exit;
}
$stmt = $conn->prepare("UPDATE orders SET sender_account=?, status='pending' WHERE id=?");
if (!$stmt) {
    echo json_encode(['success'=>false, 'error'=>'Gagal prepare statement: '.$conn->error]);
    exit;
}
$stmt->bind_param("si", $sender_account, $order_id);
if ($stmt->execute()) {
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false, 'error'=>'Gagal update database: ' . $stmt->error]);
}

$stmt->close();
?>