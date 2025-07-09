<?php
require_once("config_vnpay.php");

$vnp_SecureHash = $_GET['vnp_SecureHash'];
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}
unset($inputData['vnp_SecureHash']);

ksort($inputData);
$hashData = "";
foreach ($inputData as $key => $value) {
    $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
}
$hashData = rtrim($hashData, '&');

$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

if ($secureHash == $vnp_SecureHash) {
    if ($_GET['vnp_ResponseCode'] == '00') {
        echo "<h2>✅ Thanh toán thành công!</h2>";
    } else {
        echo "<h2>❌ Thanh toán thất bại. Mã lỗi: " . $_GET['vnp_ResponseCode'] . "</h2>";
    }
} else {
    echo "<h2>❌ Sai chữ ký hash!</h2>";
}
?>
