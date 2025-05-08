<?php
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phân tích hiệu quả chiến dịch Affiliate Marketing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #ccc;
            padding: 32px;
        }

        h1 {
            color: #007bff;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            text-align: center;
        }

        th {
            background: #e9ecef;
        }

        .success {
            color: #28a745;
            font-weight: bold;
        }

        .fail {
            color: #dc3545;
            font-weight: bold;
        }

        .neutral {
            color: #ffc107;
            font-weight: bold;
        }

        .section-title {
            margin-top: 32px;
            color: #343a40;
            font-size: 1.1em;
        }

        pre {
            background: #f1f3f4;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Phân tích hiệu quả chiến dịch Affiliate Marketing</h1>
        <?php
        const COMMISSION_RATE = 0.2;
        const VAT_RATE = 0.1;

        $campaignName = "Spring Sale 2025";
        $orderCount = 150;
        $productPrice = 99.99;
        $productType = "Thời trang";
        $campaignStatus = true;
        $orderList = array(
            "ID001" => 0,
            "ID002" => 0,
            "ID003" => 0,
            "ID004" => 0,
            "ID005" => 0
        );
        
        $totalAssigned = 0;
        $orderIds = array_keys($orderList);
        foreach ($orderIds as $id) {
            if ($totalAssigned < $orderCount) {
                $remaining = $orderCount - $totalAssigned;
                $randomQuantity = rand(1, $remaining);
                $orderList[$id] = $randomQuantity;
                $totalAssigned += $randomQuantity;
            }
        }

        $totalRevenue = 0;
        foreach ($orderList as $id => $quantity) {
            $totalRevenue += $productPrice * $quantity;
        }
        
        $commissionCost = $totalRevenue * COMMISSION_RATE;
        $vatCost = $totalRevenue * VAT_RATE;
        $profit = $totalRevenue - $commissionCost - $vatCost;

        $statusText = $campaignStatus ? "đã kết thúc" : "đang chạy";

        if ($profit > 0) {
            $result = "<span class='success'>Chiến dịch thành công</span>";
        } elseif ($profit == 0) {
            $result = "<span class='neutral'>Chiến dịch hòa vốn</span>";
        } else {
            $result = "<span class='fail'>Chiến dịch thất bại</span>";
        }

        switch ($productType) {
            case "Điện tử":
                $typeMsg = "Sản phẩm Điện tử có doanh thu biến động mạnh.";
                break;
            case "Thời trang":
                $typeMsg = "Sản phẩm Thời trang có doanh thu ổn định.";
                break;
            case "Gia dụng":
                $typeMsg = "Sản phẩm Gia dụng thường bán theo mùa.";
                break;
            default:
                $typeMsg = "Loại sản phẩm khác.";
        }

        echo "<div class='section-title'><b>Thông tin chiến dịch</b></div>";
        echo "<table><tr><th>Tên chiến dịch</th><th>Loại sản phẩm</th><th>Giá sản phẩm (USD)</th><th>Trạng thái</th></tr>";
        echo "<tr><td>$campaignName</td><td>$productType</td><td>" . number_format($productPrice, 2) . "</td><td>$statusText</td></tr></table>";
        echo "<div style='margin-bottom:8px;color:#555;'>$typeMsg</div>";

        echo "<div class='section-title'><b>Kết quả tài chính</b></div>";
        echo "<table>";
        echo "<tr><th>Tổng doanh thu</th><th>Chi phí hoa hồng</th><th>Thuế VAT</th><th>Lợi nhuận</th></tr>";
        echo "<tr>";
        echo "<td>" . number_format($totalRevenue, 2) . " USD</td>";
        echo "<td>" . number_format($commissionCost, 2) . " USD</td>";
        echo "<td>" . number_format($vatCost, 2) . " USD</td>";
        echo "<td>" . number_format($profit, 2) . " USD</td>";
        echo "</tr></table>";

        echo "<div class='section-title'><b>Đánh giá hiệu quả chiến dịch</b></div>";
        echo $result;

        echo "<div class='section-title'><b>Chi tiết đơn hàng</b></div>";
        echo "<table>";
        echo "<tr><th>STT</th><th>Mã đơn</th><th>Số lượng(đơn)</th><th>Doanh thu (USD)</th></tr>";
        $stt = 1;

        foreach ($orderList as $id => $quantity) {
            $orderRevenue = $productPrice * $quantity;
            echo "<tr><td>$stt</td><td>$id</td><td>$quantity</td><td>" . number_format($orderRevenue, 2) . "</td></tr>";
            $stt++;
        }

        echo "</table>";

        echo "<div class='section-title'><b>Dữ liệu đơn hàng (print_r)</b></div>";
        echo "<pre>";
        print_r($orderList);
        echo "</pre>";

        echo "<div class='section-title'><b>Thông báo tổng kết</b></div>";
        print "Chiến dịch $campaignName $statusText với lợi nhuận: " . number_format($profit, 2) . " USD<br>\n";
        ?>
    </div>
</body>

</html>
