<?php
session_start();
// Xử lý thêm cộng tác viên mới từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? 'normal';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $commissionRate = floatval($_POST['commissionRate'] ?? 0);
    $isActive = isset($_POST['isActive']) && $_POST['isActive'] == '1';
    if ($type === 'premium') {
        $bonusPerOrder = floatval($_POST['bonusPerOrder'] ?? 0);
        $_SESSION['affiliates'][] = [
            'type' => 'premium',
            'name' => $name,
            'email' => $email,
            'commissionRate' => $commissionRate,
            'bonusPerOrder' => $bonusPerOrder,
            'isActive' => $isActive
        ];
    } else {
        $_SESSION['affiliates'][] = [
            'type' => 'normal',
            'name' => $name,
            'email' => $email,
            'commissionRate' => $commissionRate,
            'isActive' => $isActive
        ];
    }
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm cộng tác viên mới</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; margin: 0; padding: 0; }
        .container { max-width: 500px; margin: 40px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        h2 { color: #2c3e50; }
        label { display: block; margin-bottom: 6px; font-weight: bold; }
        input, select { width: 100%; padding: 7px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 4px; }
        .row { display: flex; gap: 16px; }
        .row > div { flex: 1; }
        .bonus-row { display: none; }
        .show-bonus .bonus-row { display: block; }
        button { background: #27ae60; color: #fff; border: none; padding: 10px 24px; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background: #219150; }
        .back-link { display: inline-block; margin-bottom: 18px; color: #3498db; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
    <script>
    function toggleBonusField() {
        var type = document.getElementById('type').value;
        var form = document.getElementById('affiliateForm');
        if(type === 'premium') {
            form.classList.add('show-bonus');
        } else {
            form.classList.remove('show-bonus');
        }
    }
    </script>
</head>
<body>
<div class="container">
    <a href="index.php" class="back-link">&larr; Quay lại danh sách</a>
    <h2>Thêm cộng tác viên mới</h2>
    <form method="post" id="affiliateForm" oninput="toggleBonusField()">
        <div class="row">
            <div>
                <label for="name">Họ tên</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
        </div>
        <div class="row">
            <div>
                <label for="commissionRate">Tỷ lệ hoa hồng (%)</label>
                <input type="number" name="commissionRate" id="commissionRate" min="0" step="0.01" required>
            </div>
            <div>
                <label for="type">Loại CTV</label>
                <select name="type" id="type" onchange="toggleBonusField()">
                    <option value="normal">Thường</option>
                    <option value="premium">Cao cấp</option>
                </select>
            </div>
        </div>
        <div class="row bonus-row">
            <div>
                <label for="bonusPerOrder">Bonus/đơn (VNĐ)</label>
                <input type="number" name="bonusPerOrder" id="bonusPerOrder" min="0" step="1000">
            </div>
        </div>
        <div class="row">
            <div>
                <label for="isActive">Trạng thái hoạt động</label>
                <select name="isActive" id="isActive">
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Ngừng hoạt động</option>
                </select>
            </div>
            <div style="flex:1;display:flex;align-items:end;">
                <button type="submit">Thêm cộng tác viên</button>
            </div>
        </div>
    </form>
</div>
</body>
</html> 