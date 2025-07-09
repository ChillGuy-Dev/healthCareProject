<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán | HealthFit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h1 class="text-2xl font-bold mb-6 text-center text-green-600">Thông tin thanh toán</h1>
            <form action="payment_vnpay.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Họ tên khách hàng</label>
                    <input type="text" name="customer_name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Số điện thoại</label>
                    <input type="text" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Địa chỉ giao hàng</label>
                    <textarea name="address" required rows="2" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>
                <div>
                    <?php
    $product = $_GET['product'] ?? 'Sản phẩm chưa xác định';
    $amount = $_GET['price'] ?? 300000;
?>
<!-- form phía dưới -->
<div>
    <label class="block text-gray-700 font-medium mb-1">Số tiền thanh toán (VND)</label>
    <input type="number" name="amount" value="<?= htmlspecialchars($amount) ?>" readonly class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100">
</div>


                <div>
                    <label class="block text-gray-700 font-medium mb-1">Mô tả đơn hàng</label>
                    <input type="text" id="product" name="order_desc" value="Thanh toán đơn hàng chăm sóc sức khỏe" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">

                </div>
               <div class="flex justify-center mt-4">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                      Thanh toán qua VNPay
             </button>
                </div>

            </form>
            <div class="mt-6 text-center">
                <a href="../html/products.html" class="text-sm text-green-600 hover:underline">← Quay lại trang sản phẩm</a>
            </div>
            
        </div>
    </div>
</body>
</html>
