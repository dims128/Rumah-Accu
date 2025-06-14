<?php
session_start();

// Dummy data in session (simulate database)
if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [
        [ "id" => 101, "status" => "Diproses" ],
        [ "id" => 102, "status" => "Dikirim" ],
        [ "id" => 103, "status" => "Selesai" ],
    ];
}
$reasons = [
    "Ingin mengubah pesanan",
    "Harga terlalu mahal",
    "Menemukan produk lain",
    "Kurang yakin dengan pesanan",
    "Lainnya"
];

header("Content-Type: application/json");

$action = $_GET['action'] ?? '';

if ($action === 'list') {
    echo json_encode(array_values($_SESSION['orders']));
    exit;
}
if ($action === 'reasons') {
    echo json_encode($reasons);
    exit;
}
if ($action === 'cancel' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = intval($_POST['orderId'] ?? 0);
    $reason = $_POST['reason'] ?? '';
    if (!$orderId || !in_array($reason, $reasons)) {
        http_response_code(400);
        echo json_encode([ "error" => "Data tidak valid." ]);
        exit;
    }
    foreach ($_SESSION['orders'] as &$o) {
        if ($o['id'] == $orderId) {
            if ($o['status'] === 'Dibatalkan') {
                echo json_encode([ "message" => "Pesanan sudah dibatalkan!" ]);
                exit;
            }
            $o['status'] = 'Dibatalkan';
            // Bisa dicatat alasan di log/DB di sini
            echo json_encode([ "message" => "Pesanan berhasil dibatalkan dengan alasan: $reason" ]);
            exit;
        }
    }
    echo json_encode([ "error" => "Pesanan tidak ditemukan." ]);
    exit;
}
echo json_encode([ "error" => "Aksi tidak diketahui." ]);