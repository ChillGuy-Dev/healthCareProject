<?php
require_once("config_vnpay.php");

$vnp_TxnRef = rand(10000,999999);
$vnp_OrderInfo = $_POST['order_desc'];
$vnp_OrderType = "billpayment";
$vnp_Amount = $_POST['amount'] * 100; // nhân 100 vì đơn vị là VNĐ * 100
$vnp_Locale = "vn";
$vnp_BankCode = "";
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
$vnp_CreateDate = date('YmdHis');

$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => $vnp_CreateDate,
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef
);

ksort($inputData);
$query = "";
$hashdata = "";
foreach ($inputData as $key => $value) {
    $hashdata .= urlencode($key) . "=" . urlencode($value) . '&';
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}
$hashdata = rtrim($hashdata, '&');
$query = rtrim($query, '&');
$vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

$vnp_Url = $vnp_Url . "?" . $query . '&vnp_SecureHash=' . $vnp_SecureHash;

header('Location: ' . $vnp_Url);
exit;
