<?php
include 'db.php';
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
file_put_contents("debug_post.txt", print_r($_POST, true));
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Validasi hanya POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Hanya menerima request POST']);
    exit;
}

// Validasi kunci POST
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'user';
// Validasi data
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'error' => 'Username dan Password wajib diisi']);
    exit;
}
if (!preg_match('/^[a-zA-Z0-9]{3,}$/', $username)) {
    echo json_encode(['success' => false, 'error' => 'Username hanya boleh berisi huruf dan angka, minimal 3 karakter']);
    exit;
}
if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'error' => 'Password harus minimal 8 karakter']);
    exit;
}
if (!in_array($role, ['user', 'admin'])) {
    echo json_encode(['success' => false, 'error' => 'Role tidak valid']);
    exit;
}


$hashed_password = $password; // Simpan password tanpa hashing

// Cek apakah username sudah terdaftar
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Username sudah terdaftar']);
    exit;
}

// Simpan pengguna baru ke database
$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $password, $role);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    $errorMsg = "Database error: " . $stmt->error;
    error_log($errorMsg, 3, "error_log.txt");  // Simpan di file
    echo json_encode(['success' => false, 'error' => $errorMsg]); // Kirim ke browser
}

