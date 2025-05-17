<?php
// controllers/CartController.php
session_start();

class CartController {
    public function add() {
        $input = json_decode(file_get_contents('php://input'), true);
        $productId = $input['productId'] ?? null;

        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu productId']);
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        } else {
            $_SESSION['cart'][$productId] = 1;
        }

        $cartCount = array_sum($_SESSION['cart']);
        echo json_encode(['success' => true, 'cartCount' => $cartCount]);
    }

    public function count() {
        session_start();
        $cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
        echo json_encode(['cartCount' => $cartCount]);
    }
}
?>
