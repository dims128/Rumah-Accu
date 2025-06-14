<?php
header('Content-Type: application/json');
include 'db.php'; // Pastikan koneksi.php berada di lokasi yang benar

// Ambil data dari request POST
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$role = $_POST['role'] ?? '';

// Validasi input
if (empty($username) || empty($password) || empty($role)) {
    echo json_encode(['success' => false, 'error' => 'Semua field wajib diisi.']);
    exit();
}

// Debug input data untuk memastikan data dikirim dengan benar
file_put_contents('debug_post.txt', print_r($_POST, true));

// Query ke database untuk mencari username dan role
$sql = "SELECT * FROM users WHERE username = ? AND role = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $username, $role);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Jika user tidak ditemukan, catat di debug file
    file_put_contents('debug_sql.txt', "User not found for username: $username with role: $role\n", FILE_APPEND);
    echo json_encode(['success' => false, 'error' => 'Username atau role salah.']);
    exit();
}

$row = $result->fetch_assoc();

// Debug hasil query
file_put_contents('debug_sql.txt', "Query Result: " . print_r($row, true) . "\n", FILE_APPEND);

// Validasi password tanpa hash
if ($password !== $row['password']) {
    // Jika password salah, catat di debug file
    file_put_contents('debug_sql.txt', "Password mismatch for username: $username\n", FILE_APPEND);
    echo json_encode(['success' => false, 'error' => 'Password salah.']);
    exit();
}

// Login berhasil, buat session
session_start();
$_SESSION['user_id'] = $row['id'];        // ← Tambahkan baris ini
$_SESSION['username'] = $row['username'];
$_SESSION['role'] = $row['role'];


// Debug informasi login berhasil
file_put_contents('debug_sql.txt', "Login success for username: $username with role: $row[role]\n", FILE_APPEND);

// Kirim respons JSON
echo json_encode([
    'success' => true,
    'role' => $row['role'],
    'session' => $_SESSION // <- debug
]);
?>