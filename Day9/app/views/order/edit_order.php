<?php
require_once '../models/Order.php';

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $order = Order::find($orderId);

    if (!$order) {
        die("Không tìm thấy đơn hàng.");
    }
} else {
    die("ID đơn hàng không được cung cấp.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Đơn Hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Sửa Đơn Hàng</h1>
        <form action="?act=edit-order" method="POST">
            <input type="hidden" name="id" value="<?= $order['id'] ?>">

            <div class="form-group">
                <label for="order_date">Ngày đặt hàng:</label>
                <input type="date" class="form-control" name="order_date" value="<?= $order['order_date'] ?>" required>
            </div>

            <div class="form-group">
                <label for="customer_name">Tên khách hàng:</label>
                <input type="text" class="form-control" name="customer_name" value="<?= $order['customer_name'] ?>" required>
            </div>

            <div class="form-group">
                <label for="note">Ghi chú:</label>
                <textarea class="form-control" name="note" rows="3"><?= $order['note'] ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
            <a href="?act=orders" class="btn btn-secondary">Quay lại danh sách</a>
        </form>
    </div>
</body>
</html>
