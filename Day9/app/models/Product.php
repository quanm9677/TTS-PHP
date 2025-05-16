<?php
require_once '../config/db.php';

class Product {
    public static function all() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO products (product_name, unit_price, stock_quantity, created_at) VALUES (:product_name, :unit_price, :stock_quantity, NOW())");
        $stmt->execute([
            'product_name' => $data['product_name'],
            'unit_price' => $data['unit_price'],
            'stock_quantity' => $data['stock_quantity']
        ]);
        return $pdo->lastInsertId();
    }

    public static function delete($id) {
        global $pdo;

        // Đầu tiên, xóa các bản ghi liên quan trong order_items
        $stmt = $pdo->prepare("DELETE FROM order_items WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $id]);

        // Bây giờ xóa sản phẩm
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public static function update($id, $data) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE products SET product_name = :product_name, unit_price = :unit_price, stock_quantity = :stock_quantity WHERE id = :id");
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function filterByPrice($minPrice) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM products WHERE unit_price > :minPrice");
        $stmt->execute(['minPrice' => $minPrice]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function orderByPriceDesc() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM products ORDER BY unit_price DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>