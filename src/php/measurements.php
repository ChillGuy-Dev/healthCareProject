<?php
session_start();
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $data = json_decode(file_get_contents('php://input'), true);

    $user_id = $_SESSION['user_id'];
    $height = $data['height'] ?? null;
    $weight = $data['weight'] ?? null;
    $fat = $data['fat_percentage'] ?? null;
    $muscle = $data['muscle_mass'] ?? null;
    $date = $data['date'] ?? date('Y-m-d');
    $notes = $data['notes'] ?? '';
    
    // Validate
    if (!$height || !$weight) {
        echo json_encode(['status' => 'error', 'message' => 'Thiếu chiều cao hoặc cân nặng']);
        exit;
    }

    $bmi = round($weight / (($height / 100) ** 2), 1); // cm -> m

    $stmt = $pdo->prepare("INSERT INTO measurements 
        (user_id, height, weight, bmi, fat_percentage, muscle_mass, date, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $success = $stmt->execute([
        $user_id, $height, $weight, $bmi, $fat, $muscle, $date, $notes
    ]);

    echo json_encode([
        'status' => $success ? 'success' : 'error',
        'message' => $success ? 'Đã lưu thành công' : 'Lỗi khi lưu dữ liệu'
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập hoặc yêu cầu không hợp lệ']);
}
?>
