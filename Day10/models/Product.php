<?php
// models/Product.php
require_once "config/db.php";

class Product {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT id, name, price FROM products"); // chắc chắn có 'price' ở đây
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function search($keyword) {
        $keyword = "%$keyword%";
        $stmt = $this->conn->prepare("SELECT id, name, price, image FROM products WHERE name LIKE ? LIMIT 10");
        $stmt->execute([$keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
