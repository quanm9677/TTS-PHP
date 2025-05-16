    <!-- /app/views/orders.php -->
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Danh sách đơn hàng</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    </head>
    <body>
        <div class="container mt-5">
            <h1 class="text-center">Danh sách đơn hàng</h1>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Ghi chú</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $order['order_date'] ?></td>
                        <td><?= $order['customer_name'] ?></td>
                        <td><?= $order['note'] ?></td>
                        <td>
                            <a class="btn btn-info" href="?act=view-order&id=<?= $order['id'] ?>">Xem</a>
                            <button onclick="confirmDelete(<?= $order['id'] ?>)" class="btn btn-danger">Xóa</button>
                            <a class="btn btn-warning" href="?act=edit-order&id=<?= $order['id'] ?>">Sửa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a class="btn btn-success" href="?act=add-order">Thêm đơn hàng mới</a>
        </div>

        <script>
        function confirmDelete(orderId) {
            if (confirm("Bạn có muốn xác nhận xóa?")) {
                // Nếu người dùng xác nhận, thực hiện yêu cầu xóa
                window.location.href = '?act=delete-order&id=' + orderId;
                // Thay đổi đường dẫn đến tệp PHP của bạn
            }
        }
        </script>
    </body>
    </html>