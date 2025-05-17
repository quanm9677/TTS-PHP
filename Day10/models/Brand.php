<?php
// models/Brand.php
require_once "config/db.php";

class Brand {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function getBrandsByCategory($category) {
        $stmt = $this->conn->prepare("SELECT name FROM brands WHERE category = ?");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>
