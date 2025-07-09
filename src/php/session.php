<?php
session_start();
echo json_encode([
    "loggedIn" => isset($_SESSION["user_id"]),
    "name" => $_SESSION["user_name"] ?? null
]);
