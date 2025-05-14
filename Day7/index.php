<?php
session_start();
require_once __DIR__ . '/classes/AffiliatePartner.php';
require_once __DIR__ . '/classes/PremiumAffiliatePartner.php';
require_once __DIR__ . '/classes/AffiliateManager.php';

// ================== DEMO ==================
$orderValue = 2000000; // 2 triệu VNĐ

// Khởi tạo session lưu danh sách CTV nếu chưa có
if (!isset($_SESSION['affiliates'])) {
    $_SESSION['affiliates'] = [
        ['type' => 'normal', 'name' => 'Nguyễn Văn A', 'email' => 'a@gmail.com', 'commissionRate' => 5.0, 'isActive' => true],
        ['type' => 'normal', 'name' => 'Trần Thị B', 'email' => 'b@gmail.com', 'commissionRate' => 8.0, 'isActive' => false],
        ['type' => 'premium', 'name' => 'Lê Văn C', 'email' => 'c@gmail.com', 'commissionRate' => 10.0, 'bonusPerOrder' => 50000, 'isActive' => true],
    ];
}

// Tạo đối tượng AffiliateManager và nạp dữ liệu từ session
$manager = new AffiliateManager();
foreach ($_SESSION['affiliates'] as $a) {
    if ($a['type'] === 'premium') {
        $manager->addPartner(new PremiumAffiliatePartner(
            $a['name'],
            $a['email'],
            $a['commissionRate'],
            $a['bonusPerOrder'],
            $a['isActive']
        ));
    } else {
        $manager->addPartner(new AffiliatePartner(
            $a['name'],
            $a['email'],
            $a['commissionRate'],
            $a['isActive']
        ));
    }
}

// Xử lý lọc
$showActiveOnly = isset($_GET['active']) && $_GET['active'] == '1';
$partners = $showActiveOnly ? $manager->getActivePartners() : $manager->getPartners();

// Lưu lịch sử hoa hồng vào file JSON
$history = [];
foreach ($manager->getPartners() as $partner) {
    $history[] = [
        'name' => $partner->getSummary(),
        'commission' => $partner->calculateCommission($orderValue),
        'orderValue' => $orderValue,
        'timestamp' => date('c')
    ];
}
file_put_contents('commission_history.json', json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý cộng tác viên & Hoa hồng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        h2 {
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        tr:nth-child(even) {
            background: #fafafa;
        }

        .total {
            font-weight: bold;
            color: #e67e22;
        }

        .filter-btn {
            margin-bottom: 16px;
        }

        .filter-btn a {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            background: #3498db;
            color: #fff;
            margin-right: 8px;
        }

        .filter-btn a.active {
            background: #e67e22;
        }

        .add-btn {
            display: inline-block;
            margin-bottom: 24px;
            background: #27ae60;
            color: #fff;
            padding: 10px 22px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
        }

        .add-btn:hover {
            background: #219150;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Quản lý cộng tác viên</h2>
        <a href="add_affiliate.php" class="add-btn">+ Thêm cộng tác viên mới</a>
        <div class="filter-btn">
            <a href="?" class="<?php if (!$showActiveOnly) echo 'active'; ?>">Tất cả</a>
            <a href="?active=1" class="<?php if ($showActiveOnly) echo 'active'; ?>">Chỉ CTV đang hoạt động</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Tỷ lệ hoa hồng</th>
                    <th>Trạng thái</th>
                    <th>Nền tảng</th>
                    <th>Bonus/đơn</th>
                    <th>Hoa hồng (<?php echo number_format($orderValue, 0, ',', '.'); ?> VNĐ)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partners as $partner): ?>
                    <?php
                    $commission = $partner->calculateCommission($orderValue);
                    // Lấy thông tin chi tiết
                    $summary = explode(' | ', $partner->getSummary());
                    $name = $email = $rate = $status = $platform = $bonus = '';
                    foreach ($summary as $item) {
                        if (strpos($item, 'Tên:') === 0) $name = trim(str_replace('Tên:', '', $item));
                        if (strpos($item, 'Email:') === 0) $email = trim(str_replace('Email:', '', $item));
                        if (strpos($item, 'Tỷ lệ hoa hồng:') === 0) $rate = trim(str_replace('Tỷ lệ hoa hồng:', '', $item));
                        if (strpos($item, 'Trạng thái:') === 0) $status = trim(str_replace('Trạng thái:', '', $item));
                        if (strpos($item, 'Nền tảng:') === 0) $platform = trim(str_replace('Nền tảng:', '', $item));
                        if (strpos($item, 'Bonus/đơn:') === 0) $bonus = trim(str_replace('Bonus/đơn:', '', $item));
                    }
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($name); ?></td>
                        <td><?php echo htmlspecialchars($email); ?></td>
                        <td><?php echo htmlspecialchars($rate); ?></td>
                        <td><?php echo htmlspecialchars($status); ?></td>
                        <td><?php echo htmlspecialchars($platform); ?></td>
                        <td><?php echo htmlspecialchars($bonus); ?></td>
                        <td><?php echo number_format($commission, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="total">
            >>> Tổng hoa hồng hệ thống cần chi trả: <?php
                                                    $total = 0;
                                                    foreach ($partners as $partner) {
                                                        $total += $partner->calculateCommission($orderValue);
                                                    }
                                                    echo number_format($total, 0, ',', '.');
                                                    ?> VNĐ
        </div>
        <div style="margin-top:24px; font-size:13px; color:#888;">
            <b>Lưu ý:</b> Lịch sử hoa hồng được lưu vào file <code>commission_history.json</code> mỗi lần tải trang.<br>
            Để kiểm tra, hãy mở file này trong thư mục dự án.
        </div>
    </div>
</body>

</html>