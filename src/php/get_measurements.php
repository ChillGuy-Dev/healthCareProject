<?php
require_once 'db.php';
session_start();
header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Chưa đăng nhập']);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM measurements WHERE user_id = ? ORDER BY date DESC");
$stmt->execute([$user_id]);
$measurements = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($measurements);
?>
