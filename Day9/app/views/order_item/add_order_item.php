<!-- /app/views/order_item/add_order_item.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm mục đơn hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="/style.css"> <!-- Thêm liên kết đến tệp CSS của bạn -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Thêm mục đơn hàng mới</h1>
        <form action="?act=add-order-item" method="POST">
            <div class="form-group">
                <label for="order_id">ID Đơn hàng:</label>
                <input type="number" class="form-control" name="order_id" required>
            </div>
            <div class="form-group">
                <label for="product_id">ID Sản phẩm:</label>
                <input type="number" class="form-control" name="product_id" required>
            </div>
            <div class="form-group">
                <label for="quantity">Số lượng:</label>
                <input type="number" class="form-control" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="price_at_order_time">Giá tại thời điểm đặt hàng:</label>
                <input type="number" class="form-control" name="price_at_order_time" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-success">Thêm mục đơn hàng</button>
            <a class="btn btn-secondary" href="?act=order-items">Quay lại danh sách mục đơn hàng</a>
        </form>
    </div>
</body>
</html>