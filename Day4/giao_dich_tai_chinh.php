<?php
// Bắt đầu phiên làm việc
session_start();

// Biến toàn cục để lưu tổng thu và tổng chi
if (!isset($GLOBALS['total_income'])) {
    $GLOBALS['total_income'] = 0;
}
if (!isset($GLOBALS['total_expense'])) {
    $GLOBALS['total_expense'] = 0;
}

// Kiểm tra nếu biểu mẫu được gửi và xử lý
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['delete_index'])) {
    // Nhận dữ liệu từ form và xử lý
    $transaction_name = $_POST['transaction_name'];
    $amount = $_POST['amount'];
    $transaction_type = $_POST['transaction_type'];
    $note = $_POST['note'];
    $date = $_POST['date'];

    // Biến để lưu thông báo lỗi
    $errors = [];

    // Kiểm tra tên giao dịch (không chứa ký tự đặc biệt)
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $transaction_name)) {
        $errors[] = "Tên giao dịch chỉ được chứa chữ và số.";
    }

    // Kiểm tra số tiền (phải là số dương)
    if (!preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $amount) || $amount <= 0) {
        $errors[] = "Số tiền phải là số dương và không chứa ký tự chữ.";
    }

    // Kiểm tra ngày thực hiện (định dạng dd/mm/yyyy)
    if (!preg_match("/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/", $date)) {
        $errors[] = "Ngày thực hiện phải theo định dạng dd/mm/yyyy.";
    }

    // Kiểm tra ghi chú có chứa từ khóa nhạy cảm
    $sensitive_keywords = ['nợ xấu', 'vay nóng'];
    foreach ($sensitive_keywords as $keyword) {
        if (strpos(strtolower($note), strtolower($keyword)) !== false) {
            $errors[] = "Cảnh báo: Ghi chú chứa từ khóa nhạy cảm.";
        }
    }

    // Nếu không có lỗi, lưu giao dịch vào $_SESSION
    if (empty($errors)) {
        // Tạo giao dịch
        $transaction = [
            'transaction_name' => $transaction_name,
            'amount' => $amount,
            'transaction_type' => $transaction_type,
            'note' => $note,
            'date' => $date
        ];

        // Lưu vào $_SESSION
        if (!isset($_SESSION['transactions'])) {
            $_SESSION['transactions'] = [];
        }
        $_SESSION['transactions'][] = $transaction;

        // Cập nhật tổng thu, chi
        if ($transaction_type == 'thu') {
            $GLOBALS['total_income'] += $amount;
        } else {
            $GLOBALS['total_expense'] += $amount;
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Xử lý xóa giao dịch nếu có yêu cầu
if (isset($_POST['delete_index'])) {
    $del_idx = (int)$_POST['delete_index'];
    if (isset($_SESSION['transactions'][$del_idx])) {
        // Cập nhật lại tổng thu/chi khi xóa
        $del = $_SESSION['transactions'][$del_idx];
        if ($del['transaction_type'] == 'thu') {
            $GLOBALS['total_income'] -= $del['amount'];
        } else {
            $GLOBALS['total_expense'] -= $del['amount'];
        }
        array_splice($_SESSION['transactions'], $del_idx, 1);
    }
}

// Tính lại tổng thu, tổng chi từ danh sách giao dịch trong session
$GLOBALS['total_income'] = 0;
$GLOBALS['total_expense'] = 0;
if (isset($_SESSION['transactions'])) {
    foreach ($_SESSION['transactions'] as $transaction) {
        if ($transaction['transaction_type'] == 'thu') {
            $GLOBALS['total_income'] += $transaction['amount'];
        } else {
            $GLOBALS['total_expense'] += $transaction['amount'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ứng Dụng Quản Lý Giao Dịch Tài Chính</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f6f8fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 28px 24px 28px;
        }
        h1, h2, h3 {
            text-align: center;
            color: #2d3a4a;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        label {
            font-weight: 500;
            color: #34495e;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        input[type="text"], textarea {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            background: #f9fafb;
            transition: border 0.2s;
        }
        input[type="text"]:focus, textarea:focus {
            border: 1.5px solid #007bff;
            outline: none;
            background: #fff;
        }
        .radio-group {
            display: flex;
            gap: 24px;
            align-items: center;
        }
        .radio-group label {
            flex-direction: row;
            gap: 6px;
            font-weight: 400;
        }
        input[type="submit"] {
            background: linear-gradient(90deg, #007bff 60%, #00c6ff 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 0;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,123,255,0.08);
            transition: background 0.2s, transform 0.1s;
        }
        input[type="submit"]:hover {
            background: linear-gradient(90deg, #0056b3 60%, #00aaff 100%);
            transform: translateY(-2px) scale(1.03);
        }
        .error {
            color: #e74c3c;
            background: #fdecea;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 10px 18px;
            margin-bottom: 16px;
        }
        .success {
            color: #27ae60;
        }
        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            margin-top: 20px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        th, td {
            border-bottom: 1px solid #f0f0f0;
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background: #f3f7fa;
            color: #007bff;
            font-weight: 600;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:hover {
            background: #f0f8ff;
            transition: background 0.2s;
        }
        hr {
            margin: 32px 0 12px 0;
            border: none;
            border-top: 1.5px solid #e0e0e0;
        }
        .stat {
            display: flex;
            justify-content: space-between;
            background: #f3f7fa;
            border-radius: 8px;
            padding: 10px 18px;
            margin: 8px 0;
            font-size: 1.08rem;
        }
        .delete-btn {
            background: linear-gradient(90deg, #ff5858 60%, #ffb347 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 6px 14px;
            font-size: 0.98rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 1px 4px rgba(255,88,88,0.08);
            transition: background 0.2s, transform 0.1s;
        }
        .delete-btn:hover {
            background: linear-gradient(90deg, #d7263d 60%, #ffb347 100%);
            transform: scale(1.07);
        }
    </style>
</head>
<body>
<div class="container">
<h1>Ứng Dụng Quản Lý Giao Dịch Tài Chính</h1>
<!-- Hiển thị lỗi nếu có -->
<?php
if (!empty($errors)) {
    echo '<div class="error">';
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
    echo '</div>';
}
?>
<!-- Biểu mẫu nhập giao dịch -->
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="transaction_name">Tên giao dịch:
        <input type="text" id="transaction_name" name="transaction_name" required>
    </label>
    <label for="amount">Số tiền:
        <input type="text" id="amount" name="amount" required>
    </label>
    <div class="radio-group">
        <label><input type="radio" id="thu" name="transaction_type" value="thu" required> Thu</label>
        <label><input type="radio" id="chi" name="transaction_type" value="chi" required> Chi</label>
    </div>
    <label for="note">Ghi chú:
        <textarea id="note" name="note"></textarea>
    </label>
    <label for="date">Ngày thực hiện:
        <input type="text" id="date" name="date" placeholder="dd/mm/yyyy" required>
    </label>
    <input type="submit" value="Lưu giao dịch">
</form>
<hr>
<!-- Hiển thị danh sách giao dịch -->
<h2>Danh sách giao dịch:</h2>
<?php
if (isset($_SESSION['transactions']) && !empty($_SESSION['transactions'])) {
    echo '<table>';
    echo '<tr><th>Tên giao dịch</th><th>Số tiền</th><th>Loại giao dịch</th><th>Ghi chú</th><th>Ngày thực hiện</th><th>Xóa</th></tr>';
    foreach ($_SESSION['transactions'] as $idx => $transaction) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($transaction['transaction_name']) . '</td>';
        echo '<td>' . number_format($transaction['amount'], 2) . '</td>';
        echo '<td>' . ucfirst($transaction['transaction_type']) . '</td>';
        echo '<td>' . htmlspecialchars($transaction['note']) . '</td>';
        echo '<td>' . htmlspecialchars($transaction['date']) . '</td>';
        echo '<td>';
        echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '" style="display:inline;">';
        echo '<input type="hidden" name="delete_index" value="' . $idx . '">';
        echo '<button type="submit" class="delete-btn" onclick="return confirm(\'Bạn có chắc muốn xóa giao dịch này?\');">Xóa</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>Chưa có giao dịch nào.</p>';
}
?>
<hr>
<!-- Thống kê tổng thu, tổng chi và số dư -->
<h3>Thống kê:</h3>
<div class="stat"><span><strong>Tổng thu:</strong></span> <span class="success"><?php echo number_format($GLOBALS['total_income'], 2); ?> VND</span></div>
<div class="stat"><span><strong>Tổng chi:</strong></span> <span style="color:#e74c3c"><?php echo number_format($GLOBALS['total_expense'], 2); ?> VND</span></div>
<div class="stat"><span><strong>Số dư:</strong></span> <span><strong><?php echo number_format($GLOBALS['total_income'] - $GLOBALS['total_expense'], 2); ?> VND</strong></span></div>
</div>
</body>
</html>
