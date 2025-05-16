<!-- /app/views/order_item_detail.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết mục đơn hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="/style.css"> <!-- Thêm liên kết đến tệp CSS của bạn -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Chi tiết mục đơn hàng</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thông tin mục đơn hàng</h5>
                <p class="card-text"><strong>ID:</strong> <?= $orderItem['id'] ?></p>
                <p class="card-text"><strong>ID Đơn hàng:</strong> <?= $orderItem['order_id'] ?></p>
                <p class="card-text"><strong>ID Sản phẩm:</strong> <?= $orderItem['product_id'] ?></p>
                <p class="card-text"><strong>Số lượng:</strong> <?= $orderItem['quantity'] ?></p>
                <p class="card-text"><strong>Giá tại thời điểm đặt hàng:</strong> <?= number_format($orderItem['price_at_order_time'], 2) ?> VNĐ</p>
                <a class="btn btn-primary" href="?act=order-items">Quay lại danh sách mục đơn hàng</a>
            </div>
        </div>
    </div>
</body>
</html>