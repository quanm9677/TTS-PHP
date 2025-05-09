<?php
include 'includes/header.php';

$date = $_GET['date'] ?? date('Y-m-d');
$keyword = $_GET['keyword'] ?? '';
$logFile = __DIR__ . "/logs/log_$date.txt";
?>

<form method="get">
    <label>Chọn ngày xem nhật ký:</label>
    <input type="date" name="date" value="<?= htmlspecialchars($date) ?>">
    <label style="margin-left:20px;">Tìm kiếm từ khóa:</label>
    <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Nhập từ khóa...">
    <button type="submit">Xem</button>
</form>
<br>

<?php
if (file_exists($logFile)) {
    $found = false;
    echo '<div class="log-list"><ul>';
    $fp = fopen($logFile, 'r');
    while (!feof($fp)) {
        $line = fgets($fp);
        if (trim($line) === '') continue;
        if ($keyword !== '' && stripos($line, $keyword) === false) continue;
        $found = true;
        // Đánh dấu log quan trọng
        if (stripos($line, 'thất bại') !== false) {
            echo '<li class="log-important">' . htmlspecialchars($line) . '</li>';
        } elseif (stripos($line, 'File:') !== false) {
            echo '<li class="log-file">' . htmlspecialchars($line) . '</li>';
        } else {
            echo '<li class="log-normal">' . htmlspecialchars($line) . '</li>';
        }
    }
    fclose($fp);
    echo '</ul></div>';
    if ($keyword !== '' && !$found) {
        echo '<div class="error">Không tìm thấy dòng nhật ký nào chứa từ khóa này.</div>';
    }
} else {
    echo '<div class="error">Không có nhật ký cho ngày này.</div>';
}
?>
<br>
<a href="index.php">Quay lại ghi nhật ký</a>
</div>
</body>
</html>
