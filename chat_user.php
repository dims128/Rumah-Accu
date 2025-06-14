<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include 'db.php';

// Cek login
if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "error" => "Belum login!"]);
    exit;
}

// Tangani GET (ambil pesan)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $order_id = intval($_GET['order_id'] ?? 0);

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
    $message  = trim($_POST['message'] ?? '');

    if ($message === '') {
        echo json_encode(["success" => false, "error" => "Pesan kosong!"]);
        exit;
    }

    // Cek apakah admin atau user
    $is_admin = (isset($_SESSION['username']) && strtolower($_SESSION['username']) === 'user');

    if ($is_admin) {
        // Admin: nama sender dari session
        $sender = $_SESSION['username'];
    } else {
        // User: cari username dari tabel users berdasarkan user_id di session
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(["success" => false, "error" => "User ID tidak ditemukan di session"]);
            exit;
        }
        $user_id = $_SESSION['user_id'];
        $user_stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $user_stmt->bind_param("i", $user_id);
        $user_stmt->execute();
        $user_stmt->bind_result($sender);
        if (!$user_stmt->fetch()) {
            echo json_encode(["success" => false, "error" => "User tidak ditemukan"]);
            exit;
        }
        $user_stmt->close();
    }

    // Masukkan pesan chat
    $stmt = $conn->prepare("INSERT INTO chat (order_id, sender, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $order_id, $sender, $message);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Gagal menyimpan pesan! ".$stmt->error]);
    }

    $stmt->close();
    exit;
}

// Jika bukan GET/POST
echo json_encode(["success" => false, "error" => "Metode tidak didukung!"]);
?>