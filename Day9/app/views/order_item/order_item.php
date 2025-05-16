<!-- /app/views/order_items.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách mục đơn hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Danh sách mục đơn hàng</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>ID Đơn hàng</th>
                    <th>ID Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá tại thời điểm đặt hàng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItems as $orderItem): ?>
                <tr>
                    <td><?= $orderItem['id'] ?></td>
                    <td><?= $orderItem['order_id'] ?></td>
                    <td><?= $orderItem['product_id'] ?></td>
                    <td><?= $orderItem['quantity'] ?></td>
                    <td><?= number_format($orderItem['price_at_order_time'], 2) ?> VNĐ</td>
                    <td>
                        <a class="btn btn-info" href="?act=view-order-item&id=<?= $orderItem['id'] ?>">Xem</a>
                        <button onclick="confirmDelete(<?= $orderItem['id'] ?>)" class="btn btn-danger">Xóa</button>
                        <a class="btn btn-warning" href="?act=edit-order-item&id=<?= $orderItem['id'] ?>">Sửa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn btn-success" href="?act=add-order-item">Thêm mục đơn hàng mới</a>
    </div>

    <script>
    function confirmDelete(orderItemId) {
        if (confirm("Bạn có muốn xác nhận xóa?")) {
            // Nếu người dùng xác nhận, thực hiện yêu cầu xóa
            window.location.href = '?act=delete-order-item&id=' + orderItemId; // Thay đổi đường dẫn đến tệp PHP của bạn
        }
    }
    </script>
</body>
</html>