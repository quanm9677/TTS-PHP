<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa Mục Đơn Hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="/style.css"> <!-- Thêm liên kết đến tệp CSS của bạn -->
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Sửa Mục Đơn Hàng</h1>
        <form action="?act=edit-order-item" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($orderItem['id']) ?>"> <!-- Sử dụng htmlspecialchars để bảo mật -->
            <div class="form-group">
                <label for="order_id">ID Đơn Hàng:</label>
                <input type="text" class="form-control" name="order_id" value="<?= htmlspecialchars($orderItem['order_id']) ?>" required>
            </div>
            <div class="form-group">
                <label for="product_id">ID Sản Phẩm:</label>
                <input type="text" class="form-control" name="product_id" value="<?= htmlspecialchars($orderItem['product_id']) ?>" required>
            </div>
            <div class="form-group">
                <label for="quantity">Số Lượng:</label>
                <input type="number" class="form-control" name="quantity" value="<?= htmlspecialchars($orderItem['quantity']) ?>" required>
            </div>
            <div class="form-group">
                <label for="price_at_order_time">Giá Tại Thời Điểm Đặt Hàng:</label>
                <input type="text" class="form-control" name="price_at_order_time" value="<?= htmlspecialchars($orderItem['price_at_order_time']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật mục đơn hàng</button>
            <a href="?act=order-items" class="btn btn-secondary">Quay lại danh sách mục đơn hàng</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>