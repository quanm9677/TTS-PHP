<!-- /app/views/product/add_product.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="/style.css"> <!-- Thêm liên kết đến tệp CSS của bạn -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Thêm sản phẩm mới</h1>
        <form action="?act=add-product" method="POST">
            <div class="form-group">
                <label for="product_name">Tên sản phẩm:</label>
                <input type="text" class="form-control" name="product_name" required>
            </div>
            <div class="form-group">
                <label for="unit_price">Giá:</label>
                <input type="number" class="form-control" name="unit_price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="stock_quantity">Tồn kho:</label>
                <input type="number" class="form-control" name="stock_quantity" required>
            </div>
            <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
            <a class="btn btn-secondary" href="?act=products">Quay lại danh sách sản phẩm</a>
        </form>
    </div>
</body>
</html>