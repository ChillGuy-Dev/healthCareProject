<?php
require_once 'db.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        // ✅ Gán đầy đủ session để dùng trong các file PHP khác
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];

        $redirect = ($user['role'] === 'admin') ? '/admin/admin.html' : '/html/index.html';

        echo json_encode([
            'status' => 'success',
            'redirect' => $redirect
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email hoặc mật khẩu không chính xác']);
    }
}
?>
