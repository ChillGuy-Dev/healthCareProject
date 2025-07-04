<?php
require_once 'db.php';

session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
    $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
    $fat_percentage = filter_input(INPUT_POST, 'fat_percentage', FILTER_VALIDATE_FLOAT);
    $muscle_mass = filter_input(INPUT_POST, 'muscle_mass', FILTER_VALIDATE_FLOAT);
    $date = $_POST['date'];
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
    
    // Calculate BMI
    $bmi = $weight / (($height/100) * ($height/100));
    
    // Validate inputs
    if ($height <= 0 || $weight <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Chiều cao và cân nặng phải lớn hơn 0']);
        exit;
    }
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO measurements 
            (user_id, height, weight, bmi, fat_percentage, muscle_mass, date, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $user_id, 
            $height, 
            $weight, 
            $bmi, 
            $fat_percentage, 
            $muscle_mass, 
            $date, 
            $notes
        ]);
        
        echo json_encode(['status' => 'success', 'message' => 'Đã lưu chỉ số thành công']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
    }
}

// Get measurement history
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'history') {
    try {
        $stmt = $pdo->prepare("
            SELECT date, height, weight, bmi, fat_percentage, muscle_mass 
            FROM measurements 
            WHERE user_id = ? 
            ORDER BY date DESC
            LIMIT 10
        ");
        
        $stmt->execute([$_SESSION['user_id']]);
        $measurements = $stmt->fetchAll();
        
        echo json_encode(['status' => 'success', 'data' => $measurements]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
    }
}
?>