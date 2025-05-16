<!-- /app/views/order/add_order.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm đơn hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="/style.css"> <!-- Thêm liên kết đến tệp CSS của bạn -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Thêm đơn hàng mới</h1>
        <form action="?act=add-order" method="POST">
            <div class="form-group">
                <label for="order_date">Ngày đặt hàng:</label>
                <input type="date" class="form-control" name="order_date" required>
            </div>
            <div class="form-group">
                <label for="customer_name">Tên khách hàng:</label>
                <input type="text" class="form-control" name="customer_name" required>
            </div>
            <div class="form-group">
                <label for="note">Ghi chú:</label>
                <textarea class="form-control" name="note"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Thêm đơn hàng</button>
            <a class="btn btn-secondary" href="?act=orders">Quay lại danh sách đơn hàng</a>
        </form>
    </div>
</body>
</html>