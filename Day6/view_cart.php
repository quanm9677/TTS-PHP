<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
$user = $_SESSION['user'];
$email = $user['email'];
$phone = $user['phone'];
$order = null;
if (file_exists('cart_data.json')) {
    $orders = json_decode(file_get_contents('cart_data.json'), true);
    if (is_array($orders)) {
        // Tìm đơn hàng mới nhất của user hiện tại
        for ($i = count($orders) - 1; $i >= 0; $i--) {
            if (
                isset($orders[$i]['customer_email'], $orders[$i]['customer_phone']) &&
                $orders[$i]['customer_email'] === $email &&
                $orders[$i]['customer_phone'] === $phone
            ) {
                $order = $orders[$i];
                break;
            }
        }
    }
}
$order_time = date("Y-m-d H:i:s");
$total = 0;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thông tin thanh toán</title>
    <style>
        body {
            font-family: Arial;
            background: #f6f6f6;
        }

        .container {
            background: #fff;
            max-width: 600px;
            margin: 40px auto;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #ccc;
        }

        h2,
        h3 {
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: center;
        }

        th {
            background: #2980b9;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 6px;
        }

        a {
            display: inline-block;
            margin-top: 18px;
            color: #fff;
            background: #27ae60;
            padding: 8px 18px;
            border-radius: 4px;
            text-decoration: none;
        }

        a:hover {
            background: #219150;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Thông tin đơn hàng</h2>
        <?php if ($order): ?>
        <table>
            <tr>
                <th>Tên sách</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
            <?php 
            $total = 0;
            foreach ($order['products'] as $item):
                $item_total = $item['price'] * $item['quantity'];
                $total += $item_total;
            ?>
                <tr>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td><?= number_format($item['price']) ?>đ</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item_total) ?>đ</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><b>Tổng cộng</b></td>
                <td><b><?= number_format($total) ?>đ</b></td>
            </tr>
        </table>
        <h3>Thông tin khách hàng</h3>
        <ul>
            <li>Email: <?= htmlspecialchars($order['customer_email']) ?></li>
            <li>Điện thoại: <?= htmlspecialchars($order['customer_phone']) ?></li>
            <li>Thời gian đặt: <?= htmlspecialchars($order['created_at']) ?></li>
        </ul>
        <?php else: ?>
            <div style="color:red">Không tìm thấy đơn hàng nào cho tài khoản này.</div>
        <?php endif; ?>
        <a href="index.php">Quay lại đặt hàng</a>
    </div>
</body>

</html>