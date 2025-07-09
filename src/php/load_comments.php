<?php

function loadComments($trainer_id) {
    // Kết nối đúng thông tin Docker Compose
    $conn = new mysqli("db", "root", "root", "healthfit");
    if ($conn->connect_error) die("Kết nối thất bại");

    $stmt = $conn->prepare("SELECT name, message, created_at FROM comments WHERE trainer_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $trainer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><strong>" . htmlspecialchars($row['name']) . "</strong>: " . htmlspecialchars($row['message']) . " <em>(" . $row['created_at'] . ")</em></li>";
    }
    echo "</ul>";

    $stmt->close();
    $conn->close();
}
?>
