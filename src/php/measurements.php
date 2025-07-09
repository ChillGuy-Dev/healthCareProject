<?php
session_start();
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $data = json_decode(file_get_contents('php://input'), true);

    $user_id = $_SESSION['user_id'];
    $height = $data['height'];
    $weight = $data['weight'];
    $fat_percentage = $data['fat_percentage'];
    $muscle_mass = $data['muscle_mass'];
    $date = $data['date'];
    $notes = $data['notes'];
    $bmi = $weight / (($height / 100) ** 2);

    $stmt = $pdo->prepare("INSERT INTO measurements (user_id, height, weight, bmi, fat_percentage, muscle_mass, date, notes)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $height, $weight, $bmi, $fat_percentage, $muscle_mass, $date, $notes]);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập hoặc yêu cầu không hợp lệ']);
}
?>
