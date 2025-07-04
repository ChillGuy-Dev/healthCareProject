
<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.html');
    exit;
}

// Thống kê
try {
    $userCount = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();
    $feedbackCount = $pdo->query("SELECT COUNT(*) FROM feedback")->fetchColumn();
    $measurementCount = $pdo->query("SELECT COUNT(*) FROM measurements")->fetchColumn();
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị viên | HealthFit</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-md py-4 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-green-600">HealthFit Admin</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Xin chào, <?= htmlspecialchars($_SESSION['name']) ?>!</span>
                <a href="logout.php" class="text-red-500 hover:underline">Đăng xuất</a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-6">Bảng điều khiển quản trị viên</h2>

        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="card">
                <p class="text-gray-500 mb-1">Tổng người dùng</p>
                <h3 class="text-2xl font-bold"><?= $userCount ?></h3>
            </div>
            <div class="card">
                <p class="text-gray-500 mb-1">Tổng lượt đo</p>
                <h3 class="text-2xl font-bold"><?= $measurementCount ?></h3>
            </div>
            <div class="card">
                <p class="text-gray-500 mb-1">Phản hồi</p>
                <h3 class="text-2xl font-bold"><?= $feedbackCount ?></h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold mb-4">Biểu đồ người dùng</h3>
            <canvas id="userChart" height="200"></canvas>
        </div>
    </main>

    <script>
    const ctx = document.getElementById('userChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
                datasets: [
                    {
                        label: 'Người dùng mới',
                        data: [210, 190, 220, 250, 300],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });
    }
    </script>
</body>
</html>
