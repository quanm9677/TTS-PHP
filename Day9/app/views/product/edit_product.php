<!-- /app/views/edit_product.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cập nhật sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="/style.css"> <!-- Thêm liên kết đến tệp CSS của bạn -->
</head>

<body>
    <h1>Cập nhật sản phẩm</h1>
    <form action="?act=edit-product" method="POST">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <div class="form-group">
            <label for="product_name">Tên sản phẩm:</label>
            <input type="text" class="form-control" name="product_name" value="<?= $product['product_name'] ?>" required>
        </div>
        <div class="form-group">
            <label for="unit_price">Giá:</label>
            <input type="number" class="form-control" name="unit_price" step="0.01" value="<?= $product['unit_price'] ?>" required>
        </div>
        <div class="form-group">
            <label for="stock_quantity">Tồn kho:</label>
            <input type="number" class="form-control" name="stock_quantity" value="<?= $product['stock_quantity'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a class="btn btn-secondary" href="?act=products">Hủy</a>
    </form>
    <a href="?act=products">Quay lại danh sách sản phẩm</a>
</body>

</html>