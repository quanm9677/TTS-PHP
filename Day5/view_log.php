<?php
include 'includes/header.php';

$date = $_GET['date'] ?? date('Y-m-d');
$logFile = __DIR__ . "/logs/log_$date.txt";
?>

<form method="get">
    <label>Chọn ngày xem nhật ký:</label>
    <input type="date" name="date" value="<?= htmlspecialchars($date) ?>">
    <button type="submit">Xem</button>
</form>
<br>

<?php
if (file_exists($logFile)) {
    echo '<div class="log-list"><ul>';
    $fp = fopen($logFile, 'r');
    while (!feof($fp)) {
        $line = fgets($fp);
        if (trim($line) === '') continue;
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
} else {
    echo '<div class="error">Không có nhật ký cho ngày này.</div>';
}
?>
<br>
<a href="index.php">Quay lại ghi nhật ký</a>
</div>
</body>
</html>
