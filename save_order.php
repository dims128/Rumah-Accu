<?php
include 'db.php'; // Pastikan koneksi database Anda benar

header('Content-Type: application/json');

// Ambil data dari POST request
$data = json_decode(file_get_contents('php://input'), true);

// Validasi input data
if (!isset($data['user_id'], $data['product_id'], $data['quantity'], $data['total_price'], $data['address'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    http_response_code(400); // Bad Request
    exit;
}

// Ambil data dari request
$user_id = $data['user_id'];
$product_id = $data['product_id'];
$quantity = $data['quantity'];
$total_price = $data['total_price'];
$address = $data['address'];

// Nilai default untuk kolom yang tidak disediakan
$status = 'pending'; // Default status pesanan
$cancel_reason = null;
$payment_status = 'unpaid'; // Default status pembayaran

// Query untuk menyimpan pesanan ke database
$sql = "INSERT INTO orders (user_id, address, product_id, quantity, total_price, status, cancel_reason, payment_status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

// Gunakan prepared statement untuk keamanan
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Gagal menyiapkan statement: ' . $conn->error]);
    http_response_code(500); // Internal Server Error
    exit;
}

// Bind parameter ke statement
$stmt->bind_param(
    'isiiisss', 
    $user_id,
    $address,
    $product_id,
    $quantity,
    $total_price,
    $status,
    $cancel_reason,
    $payment_status
);

// Eksekusi statement
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Pesanan berhasil disimpan']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan pesanan: ' . $stmt->error]);
    http_response_code(500); // Internal Server Error
}

// Tutup statement
$stmt->close();

// Tutup koneksi database
$conn->close();
?>