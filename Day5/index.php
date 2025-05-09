<?php
include 'includes/header.php';
include 'includes/logger.php';
include 'includes/upload.php';

$success = $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim($_POST['action'] ?? '');
    if ($action === '') {
        $error = "Vui lòng nhập mô tả hành động!";
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
        list($uploadedFile, $uploadError) = handle_upload('evidence');
        if ($uploadError) {
            $error = $uploadError;
        } else {
            write_log($action, $ip, $uploadedFile);
            $success = "Đã ghi nhật ký thành công!";
        }
    }
}
?>

<!-- Giao diện ghi nhật ký hoạt động -->
<div class="card">
    <h3>Ghi nhật ký hoạt động</h3>
    <?php if ($success): ?>
        <div class="alert success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="log-form">
        <div class="form-group">
            <label for="action">Mô tả hành động <span style="color:red">*</span></label>
            <input type="text" name="action" id="action" placeholder="Nhập mô tả hành động..." required>
        </div>
        <div class="form-group">
            <label for="evidence">Đính kèm file minh chứng (PDF, JPG, PNG, tối đa 2MB):</label>
            <input type="file" name="evidence" id="evidence" accept=".jpg,.jpeg,.png,.pdf">
        </div>
        <button type="submit" class="btn">Ghi nhật ký</button>
    </form>
    <div style="margin-top:20px;">
        <a href="view_log.php" class="link">Xem nhật ký theo ngày &rarr;</a>
    </div>
</div>

<!-- Thêm CSS hiện đại -->
<style>
.card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 30px 40px 25px 40px;
    max-width: 500px;
    margin: 40px auto 0 auto;
}
h3 {
    margin-top: 0;
    color: #2d6cdf;
    text-align: center;
}
.form-group {
    margin-bottom: 18px;
}
label {
    font-weight: 500;
    display: block;
    margin-bottom: 6px;
}
input[type="text"], input[type="file"] {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #d0d0d0;
    border-radius: 5px;
    font-size: 15px;
    background: #f7f9fa;
}
input[type="file"] {
    padding: 5px 0;
    background: none;
}
.btn {
    background: #2d6cdf;
    color: #fff;
    border: none;
    padding: 10px 22px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.2s;
}
.btn:hover {
    background: #1b4e9b;
}
.alert {
    padding: 10px 15px;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 15px;
}
.success { background: #e6f9e6; color: #1a7e1a; border: 1px solid #b2e6b2; }
.error { background: #ffeaea; color: #d32f2f; border: 1px solid #f5bcbc; }
.link {
    color: #2d6cdf;
    text-decoration: none;
    font-weight: 500;
    font-size: 15px;
}
.link:hover { text-decoration: underline; }
</style>
