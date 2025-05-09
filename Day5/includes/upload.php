<?php
// includes/upload.php

function handle_upload($fileInputName = 'evidence') {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return [null, null]; // Không có file upload
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    $file = $_FILES[$fileInputName];
    if (!in_array($file['type'], $allowedTypes)) {
        return [null, "Định dạng file không hợp lệ!"];
    }
    if ($file['size'] > $maxSize) {
        return [null, "File vượt quá dung lượng cho phép (2MB)!"];
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $timestamp = time();
    $safeName = "upload_{$timestamp}_" . preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $file['name']);
    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $targetPath = $uploadDir . $safeName;
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return [$safeName, null];
    } else {
        return [null, "Lỗi khi upload file!"];
    }
}
?>
