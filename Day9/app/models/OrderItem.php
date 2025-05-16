
<?php
require_once '../config/db.php';

class OrderItem {
    public static function all() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM order_items");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_order_time) VALUES (:order_id, :product_id, :quantity, :price_at_order_time)");
        $stmt->execute($data);
        return $pdo->lastInsertId();
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM order_items WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM order_items WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function update($data) {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE order_items
            SET order_id = :order_id, product_id = :product_id, quantity = :quantity, price_at_order_time = :price_at_order_time
            WHERE id = :id
        ");
        $stmt->execute($data);
    }
    
}
?>