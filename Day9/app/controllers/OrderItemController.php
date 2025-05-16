<?php
// /app/controllers/OrderItemController.php
require_once '../models/OrderItem.php';

class OrderItemController
{
    // Hiển thị danh sách tất cả mục đơn hàng
    public function index()
    {
        $orderItems = OrderItem::all();
        require '../views/order_item/order_item.php'; // Đảm bảo tên file đúng với view của bạn
    }

    // Hiển thị form thêm mục đơn hàng
    public function add()
    {
        require '../views/order_item/add_order_item.php';
    }

    // Xử lý lưu mục đơn hàng mới
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                isset($_POST['order_id']) &&
                isset($_POST['product_id']) &&
                isset($_POST['quantity']) &&
                isset($_POST['price_at_order_time'])
            ) {
                $data = [
                    'order_id' => $_POST['order_id'],
                    'product_id' => $_POST['product_id'],
                    'quantity' => $_POST['quantity'],
                    'price_at_order_time' => $_POST['price_at_order_time']
                ];

                $result = OrderItem::create($data);

                if ($result) {
                    header("Location: ?act=order-items");
                    exit();
                } else {
                    echo "Thêm mục đơn hàng thất bại!";
                }
            } else {
                echo "Vui lòng điền đầy đủ thông tin.";
            }
        }
    }

    // Xóa mục đơn hàng
    public function delete()
    {
        if (isset($_GET['id'])) {
            OrderItem::delete($_GET['id']);
            header("Location: ?act=order-items");
            exit();
        } else {
            echo "ID mục đơn hàng không hợp lệ.";
        }
    }

    // Xem chi tiết một mục đơn hàng
    public function view()
    {
        if (isset($_GET['id'])) {
            $orderItem = OrderItem::find($_GET['id']);
            if ($orderItem) {
                require '../views/order_item_detail.php';
            } else {
                echo "Không tìm thấy mục đơn hàng.";
            }
        } else {
            echo "ID mục đơn hàng không hợp lệ.";
        }
    }

    // Hiển thị form sửa mục đơn hàng
    public function edit()
    {
        if (isset($_GET['id'])) {
            $orderItem = OrderItem::find($_GET['id']);
            if ($orderItem) {
                require '../views/order_item/edit_order_item.php';
            } else {
                echo "Không tìm thấy mục đơn hàng.";
            }
        } else {
            echo "ID mục đơn hàng không hợp lệ.";
        }
    }

    // Cập nhật mục đơn hàng
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $data = [
                'id' => $_POST['id'],
                'order_id' => $_POST['order_id'],
                'product_id' => $_POST['product_id'],
                'quantity' => $_POST['quantity'],
                'price_at_order_time' => $_POST['price_at_order_time']
            ];

            OrderItem::update($data);
            header("Location: ?act=order-items");
            exit();
        } else {
            echo "Dữ liệu không hợp lệ để cập nhật.";
        }
    }
}
?>
