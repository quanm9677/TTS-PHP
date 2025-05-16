<!-- /app/views/products.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="/style.css"> <!-- Thêm liên kết đến tệp CSS của bạn -->
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Danh sách sản phẩm</h1>
        <div class="text-right mb-3">
            <a href="?act=filter-products" class="btn btn-primary">Lọc sản phẩm > 1.000.000 VNĐ</a>
            <a href="?act=order-products" class="btn btn-secondary">Sắp xếp theo giá giảm dần</a>
            <a href="?act=products" class="btn btn-warning">Reset</a>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['product_name'] ?></td>
                        <td><?= number_format($product['unit_price'], 2) ?> VNĐ</td>
                        <td><?= $product['stock_quantity'] ?></td>
                        <td>
                            <a class="btn btn-info" href="?act=view-product&id=<?= $product['id'] ?>">Xem</a>
                            <button onclick="confirmDelete(<?= $product['id'] ?>)" class="btn btn-danger">Xóa</button>
                            <a class="btn btn-warning" href="?act=edit-product&id=<?= $product['id'] ?>">Sửa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn btn-success" href="?act=add-product">Thêm sản phẩm mới</a>
    </div>

    <script>
        function confirmDelete(productId) {
            if (confirm("Bạn có muốn xác nhận xóa?")) {
                // Nếu người dùng xác nhận, thực hiện yêu cầu xóa
                window.location.href = '?act=delete-product&id=' + productId;
                // Thay đổi đường dẫn đến tệp PHP của bạn
            }
        }
    </script>
</body>

</html>