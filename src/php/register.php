<?php
require_once 'db.php';
header('Content-Type: application/json');

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$name || !$email || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đầy đủ thông tin']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    echo json_encode(['status' => 'error', 'message' => 'Email đã tồn tại']);
} else {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $password]);
    echo json_encode(['status' => 'success', 'message' => 'Đăng ký thành công']);
}
?>
