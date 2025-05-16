
<?php
require_once '../config/db.php';

class Order {
    public static function all() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO orders (order_date, customer_name, note) VALUES (:order_date, :customer_name, :note)");
        $stmt->execute($data);
        return $pdo->lastInsertId();
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public static function update($id, $data) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE orders SET order_date = :order_date, customer_name = :customer_name, note = :note WHERE id = :id");
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>