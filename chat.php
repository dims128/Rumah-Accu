<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';
session_start();
header('Content-Type: application/json');

if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'Koneksi database gagal!']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $sender = isset($_SESSION['username']) ? $_SESSION['username'] : 'anonymous';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if ($message === '') {
        echo json_encode(['success' => false, 'error' => 'Pesan tidak boleh kosong!']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO chats (order_id, sender, message) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Prepare statement gagal: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("iss", $order_id, $sender, $message);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Gagal mengirim pesan! ' . $stmt->error]);
    }
    $stmt->close();

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    $stmt = $conn->prepare("SELECT sender, message, created_at FROM chats WHERE order_id = ? ORDER BY created_at ASC");
    if (!$stmt) {
        echo json_encode([]);
        exit;
    }
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $chats = [];
    while ($row = $result->fetch_assoc()) {
        $chats[] = $row;
    }
    echo json_encode($chats);
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Request tidak valid!']);
}
?>