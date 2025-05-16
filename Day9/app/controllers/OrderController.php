
<?php
require_once '../models/Order.php';

class OrderController
{
    public function index()
    {
        $orders = Order::all();
        require '../views/order/orders.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'order_date' => $_POST['order_date'],
                'customer_name' => $_POST['customer_name'],
                'note' => $_POST['note'] ?? null
            ];
            Order::create($data);
            header("Location: ?act=orders");
            exit();
        }
    }


    public function delete()
{
    if (isset($_GET['id'])) {
        Order::delete($_GET['id']);
        header("Location: ?act=orders"); // ✔️ Đúng định tuyến
        exit(); // ✔️ Đảm bảo không chạy tiếp
    } else {
        echo "Không có ID đơn hàng cần xóa.";
    }
}


    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $data = [
                'order_date' => $_POST['order_date'],
                'customer_name' => $_POST['customer_name'],
                'note' => $_POST['note'] ?? null
            ];
            Order::update($_POST['id'], $data);
            header("Location: ?act=orders");
            exit();
        }
    }
    

    public function view()
    {
        if (isset($_GET['id'])) {
            $order = Order::find($_GET['id']);
            require '../views/order/order_detail.php'; // Tạo tệp này để hiển thị chi tiết đơn hàng
        }
    }
    // /app/controllers/OrderController.php
    public function add()
    {
        require '../views/order/add_order.php'; // Hiển thị trang thêm đơn hàng
    }

    public function edit() {
        if (isset($_GET['id'])) {
            $order = Order::find($_GET['id']);
            if ($order) {
                require '../views/order/edit_order.php'; // Include the edit order view
                return; // Exit the method after including the view
            }
        }
        echo "Không tìm thấy đơn hàng."; // Message if order not found
    }
}
?>