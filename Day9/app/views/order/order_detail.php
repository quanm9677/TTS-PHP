<!-- /app/views/order_detail.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="/style.css"> <!-- Thêm liên kết đến tệp CSS của bạn -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Chi tiết đơn hàng</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thông tin đơn hàng</h5>
                <p class="card-text"><strong>ID:</strong> <?= $order['id'] ?></p>
                <p class="card-text"><strong>Ngày đặt hàng:</strong> <?= $order['order_date'] ?></p>
                <p class="card-text"><strong>Tên khách hàng:</strong> <?= $order['customer_name'] ?></p>
                <p class="card-text"><strong>Ghi chú:</strong> <?= $order['note'] ?></p>
                <a class="btn btn-primary" href="?act=orders">Quay lại danh sách đơn hàng</a>
            </div>
        </div>
    </div>
</body>
</html>