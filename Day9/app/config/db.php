
<?php
$host = 'localhost';
$db = 'tech_factory';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=tech_factory;charset=utf8", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}

?>  