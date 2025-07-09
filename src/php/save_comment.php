<?php

// Kết nối tới database healthfit
$conn = new mysqli("db", "root", "root", "healthfit");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$trainer_id = isset($_POST['trainer_id']) ? trim($_POST['trainer_id']) : '';
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Kiểm tra dữ liệu đầu vào
if ($trainer_id && $name && $message) {
    $stmt = $conn->prepare("INSERT INTO comments (trainer_id, name, message) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $trainer_id, $name, $message);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        ?>
        <script>
            alert("Gửi bình luận thành công!\n\nCảm ơn bạn đã gửi phản hồi cho huấn luyện viên.\n\nBấm OK để quay lại.");
            window.location.href = "../html/trainers.html";
        </script>
        <?php
        exit;
        
    } else {
        echo "Lỗi truy vấn: " . $conn->error;
    }
} else {
    echo "Vui lòng nhập đầy đủ thông tin.";
}
?>