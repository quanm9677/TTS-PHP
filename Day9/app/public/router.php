<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Chỉ khởi động phiên nếu chưa có phiên nào
}
require_once '../config/db.php'; // Kết nối CSDL

// Require Controller
require_once '../controllers/ProductController.php';
require_once '../controllers/OrderController.php';
require_once '../controllers/OrderItemController.php';

// Tạo đối tượng bộ điều khiển
$productController = new ProductController();
$orderController = new OrderController();
$orderItemController = new OrderItemController();

// Route
$act = $_GET['act'] ?? '/';
$publicRoutes = ['login', 'register']; // Các route công khai

if (!in_array($act, $publicRoutes)) {
    include_once '../views/layout/header.php'; // Bao gồm header
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($act) {
        case 'add-product':
            $productController->store();
            exit();
        case 'add-order':
            $orderController->store();
            exit();
        case 'edit-order':
            $orderController->update();
            exit();
        case 'edit-product':
            $productController->update();
            exit();
        case 'add-order-item':
            $orderItemController->store();
            exit();
        case 'edit-order-item':
            $orderItemController->update();
            exit();
    }
}

// Kiểm tra act và điều hướng tới các controller phù hợp
match ($act) {
    '/' => $productController->index(), // Hiển thị danh sách sản phẩm
    'products' => $productController->index(), // Hiển thị danh sách sản phẩm
    'add-product' => $productController->add(), // Hiển thị trang thêm sản phẩm
    'delete-product' => $productController->delete(), // Xóa sản phẩm
    'view-product' => $productController->view(), // Xem chi tiết sản phẩm
    'orders' => $orderController->index(), // Hiển thị danh sách đơn hàng
    'add-order' => $orderController->add(), // Hiển thị trang thêm đơn hàng
    'delete-order' => $orderController->delete(), // Xóa đơn hàng
    'view-order' => $orderController->view(), // Xem chi tiết đơn hàng
    'order-items' => $orderItemController->index(), // Hiển thị danh sách mục đơn hàng
    'add-order-item' => $orderItemController->add(), // Hiển thị trang thêm mục đơn hàng
    'delete-order-item' => $orderItemController->delete(), // Xóa mục đơn hàng
    'view-order-item' => $orderItemController->view(), // Xem chi tiết mục đơn hàng
    'edit-order' => $orderController->edit(),
    'edit-product' => $productController->edit(),
    'edit-order-item' => $orderItemController->edit(),
    'filter-products' => $productController->filterByPrice(), // Lọc sản phẩm
    'order-products' => $productController->orderByPriceDesc(), // Sắp xếp sản phẩm theo giá giảm dần
    default => http_response_code(404), // Trả về 404 nếu không tìm thấy route
};

if (!in_array($act, $publicRoutes)) {
    include_once '../views/layout/footer.php'; // Bao gồm footer
}
