<?php
require_once 'db.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đầy đủ email và mật khẩu']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        echo json_encode([
            'status' => 'success',
            'message' => 'Đăng nhập thành công',
            'redirect' => $user['role'] === 'admin' ? '/admin/admin.html' : '/user/user.html'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email hoặc mật khẩu không chính xác']);
    }
}
?>
