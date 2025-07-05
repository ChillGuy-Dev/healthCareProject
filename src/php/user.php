<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: index.html');
    exit;
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];

// Fetch latest measurements
try {
    $stmt = $pdo->prepare("SELECT * FROM measurements WHERE user_id = ? ORDER BY date DESC LIMIT 1");
    $stmt->execute([$user_id]);
    $latest = $stmt->fetch();
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản người dùng | HealthFit</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-md py-4 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-green-600">HealthFit</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Xin chào, <?= htmlspecialchars($name) ?>!</span>
                <a href="logout.php" class="text-red-500 hover:underline">Đăng xuất</a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-6">Bảng điều khiển của bạn</h2>

        <?php if ($latest): ?>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold mb-4">Chỉ số gần nhất</h3>
                <ul class="space-y-2">
                    <li><strong>Ngày đo:</strong> <?= $latest['date'] ?></li>
                    <li><strong>Cân nặng:</strong> <?= $latest['weight'] ?> kg</li>
                    <li><strong>Chiều cao:</strong> <?= $latest['height'] ?> cm</li>
                    <li><strong>BMI:</strong> <?= round($latest['bmi'], 1) ?></li>
                    <li><strong>Mỡ:</strong> <?= $latest['fat_percentage'] ?>%</li>
                    <li><strong>Cơ bắp:</strong> <?= $latest['muscle_mass'] ?> kg</li>
                </ul>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <p>Bạn chưa có dữ liệu đo chỉ số. <a href="measurement.html" class="text-green-600 underline">Đo ngay</a></p>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">Biểu đồ tiến trình</h3>
            <canvas id="progressChart" height="200"></canvas>
        </div>
    </main>

    <script>
    // Chart placeholder
    const ctx = document.getElementById('progressChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
                datasets: [
                    {
                        label: 'Cân nặng (kg)',
                        data: [68.5, 67.8, 67.2, 66.1, 65.2],
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Tỷ lệ mỡ (%)',
                        data: [22.5, 21.8, 20.4, 19.2, 18.3],
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: { beginAtZero: false }
                }
            }
        });
    }
    </script>
</body>
</html>