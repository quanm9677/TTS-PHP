<!-- /app/views/product_detail.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="/style.css"> <!-- Thêm liên kết đến tệp CSS của bạn -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Chi tiết sản phẩm</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thông tin sản phẩm</h5>
                <p class="card-text"><strong>ID:</strong> <?= $product['id'] ?></p>
                <p class="card-text"><strong>Tên sản phẩm:</strong> <?= $product['product_name'] ?></p>
                <p class="card-text"><strong>Giá:</strong> <?= number_format($product['unit_price'], 2) ?> VNĐ</p>
                <p class="card-text"><strong>Tồn kho:</strong> <?= $product['stock_quantity'] ?></p>
                <p class="card-text"><strong>Ngày tạo:</strong> <?= $product['created_at'] ?></p>
                <a class="btn btn-primary" href="?act=products">Quay lại danh sách sản phẩm</a>
            </div>
        </div>
    </div>
</body>
</html>