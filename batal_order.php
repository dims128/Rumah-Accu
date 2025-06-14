<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id'] ?? 0);
    $alasan = trim($_POST['alasan'] ?? '');
    $pesan  = trim($_POST['pesan'] ?? '');

    // Update status pesanan
    $stmt = $conn->prepare("UPDATE orders SET status='canceled' WHERE id=? AND (status='pending' OR status='proses')");
    $stmt->bind_param("i", $order_id);
    if (!$stmt->execute()) {
        echo json_encode(['success'=>false, 'error'=>'Update gagal!']);
        exit;
    }
    $stmt->close();

    // Simpan pesan pembatalan ke tabel pembatalan (atau tabel pesan/chat admin)
    $stmt2 = $conn->prepare("INSERT INTO pembatalan (order_id, alasan, pesan, created_at) VALUES (?, ?, ?, NOW())");
    $stmt2->bind_param("iss", $order_id, $alasan, $pesan);
    $stmt2->execute();
    $stmt2->close();

    // Bisa juga masukkan ke chat admin dengan: INSERT INTO chats (order_id, sender, message, created_at) VALUES (?,?,?,NOW())
    echo json_encode(['success'=>true]);
}
?>