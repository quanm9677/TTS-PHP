<?php
session_start();

function validateInput(&$errors) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_VALIDATE_REGEXP, [
        "options" => ["regexp" => "/^[0-9]{9,12}$/"]
    ]);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$email) $errors[] = "Email không hợp lệ!";
    if (!$name) $errors[] = "Tên không hợp lệ!";
    if (!$phone) $errors[] = "Số điện thoại không hợp lệ!";
    if (!$address) $errors[] = "Địa chỉ không hợp lệ!";

    return [
        'email' => $email,
        'name' => $name,
        'phone' => $phone,
        'address' => $address
    ];
}

function addToCart($bookId, $bookName, $price, $quantity) {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (isset($_SESSION['cart'][$bookId])) {
        $_SESSION['cart'][$bookId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$bookId] = [
            'name' => $bookName,
            'price' => $price,
            'quantity' => $quantity
        ];
    }
}

function saveCartToJson() {
    try {
        $cart = $_SESSION['cart'];
        $user = $_SESSION['user'];
        $products = [];
        $total = 0;
        foreach ($cart as $item) {
            $products[] = [
                'title' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ];
            $total += $item['price'] * $item['quantity'];
        }
        $newOrder = [
            'customer_email' => $user['email'],
            'customer_phone' => $user['phone'],
            'products' => $products,
            'total_amount' => $total,
            'created_at' => date("Y-m-d H:i:s")
        ];

        // Đọc file cũ (nếu có)
        $orders = [];
        if (file_exists('cart_data.json')) {
            $json = file_get_contents('cart_data.json');
            $orders = json_decode($json, true);
            if (!is_array($orders)) $orders = [];
        }

        // Kiểm tra trùng email + sđt
        $found = false;
        foreach ($orders as &$order) {
            if (
                $order['customer_email'] === $newOrder['customer_email'] &&
                $order['customer_phone'] === $newOrder['customer_phone']
            ) {
                // Cộng dồn sản phẩm
                foreach ($newOrder['products'] as $newProd) {
                    $exist = false;
                    foreach ($order['products'] as &$oldProd) {
                        if ($oldProd['title'] === $newProd['title'] && $oldProd['price'] == $newProd['price']) {
                            $oldProd['quantity'] += $newProd['quantity'];
                            $exist = true;
                            break;
                        }
                    }
                    if (!$exist) {
                        $order['products'][] = $newProd;
                    }
                }
                // Cập nhật tổng tiền và thời gian
                $order['total_amount'] += $newOrder['total_amount'];
                $order['created_at'] = $newOrder['created_at'];
                $found = true;
                break;
            }
        }
        unset($order);

        if (!$found) {
            $orders[] = $newOrder;
        }

        $json = json_encode($orders, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if (file_put_contents('cart_data.json', $json) === false) {
            throw new Exception("Không thể ghi file giỏ hàng!");
        }
    } catch (Exception $e) {
        file_put_contents('log.txt', date("Y-m-d H:i:s") . " - " . $e->getMessage() . PHP_EOL, FILE_APPEND);
        echo "<div style='color:red'>Có lỗi khi lưu giỏ hàng. Vui lòng thử lại sau.</div>";
    }
}
?>
