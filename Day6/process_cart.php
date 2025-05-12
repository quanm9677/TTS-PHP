<?php
require_once 'functions.php';

$books = [
    1 => ['name' => 'Doraemon', 'price' => 100000],
    2 => ['name' => 'Shin cậu bé bút chì', 'price' => 120000],
    3 => ['name' => 'Pokemon', 'price' => 90000],
    4 => ['name' => 'Naruto', 'price' => 100000],
    5 => ['name' => 'One Piece', 'price' => 120000],
    6 => ['name' => 'One Punch Man ', 'price' => 90000]
];

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = validateInput($errors);

    // Lưu cookie tên và email 7 ngày
    setcookie('user_name', $user['name'], time() + 7*24*3600);
    setcookie('user_email', $user['email'], time() + 7*24*3600);

    if (empty($errors)) {
        $_SESSION['user'] = $user;
        // Xử lý sách
        if (isset($_POST['books'])) {
            foreach ($_POST['books'] as $bookId) {
                $quantity = intval($_POST['quantity'][$bookId]);
                if ($quantity > 0) {
                    addToCart($bookId, $books[$bookId]['name'], $books[$bookId]['price'], $quantity);
                }
            }
        }
        saveCartToJson();
        unset($_SESSION['cart']);
        header("Location: view_cart.php");
        exit;
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
