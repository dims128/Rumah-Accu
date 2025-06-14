<?php
// Tampilkan error (untuk debugging, hapus di production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include 'db.php';



// Tangani GET (ambil pesan)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $order_id = intval($_GET['order_id'] ?? 0);

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("SELECT sender, message, created_at FROM chat WHERE order_id = ? ORDER BY created_at ASC");
    $stmt->bind_param("i", $order_id);
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "error" => "Gagal mengambil pesan!"]);
        exit;
    }
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    echo json_encode($messages);
    $stmt->close();
    exit;
}

// Tangani POST (kirim pesan)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id'] ?? 0);
    $message = trim($_POST['message'] ?? '');
    $sender = 'admin'; // Ganti sesuai sistem login jika perlu

    if ($message === '') {
        echo json_encode(["success" => false, "error" => "Pesan kosong!"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO chat (order_id, sender, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $order_id, $sender, $message);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Gagal menyimpan pesan!"]);
    }

    $stmt->close();
    exit;
}

// Jika bukan GET atau POST
echo json_encode(["success" => false, "error" => "Metode tidak didukung!"]);
?>