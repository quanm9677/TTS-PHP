<!-- /app/views/layout/header.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>TechFactory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="/style.css"> <!-- Thêm liên kết đến tệp CSS của bạn -->
</head>
<body>
    <header class="bg-dark text-white text-center py-3">
        <h1>Hệ thống quản lý sản xuất TechFactory</h1>
        <nav>
            <a class="text-white" href="?act=products">Sản phẩm</a>
            <a class="text-white" href="?act=orders">Đơn hàng</a>
            <a class="text-white" href="?act=order-items">Mục đơn hàng</a>
        </nav>
    </header>