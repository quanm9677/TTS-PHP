<?php

// models/Review.php
require_once "config/db.php";

class ReviewModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getReviewsByProductId($productId) {
        $stmt = $this->pdo->prepare("SELECT user, review AS comment, rating FROM reviews WHERE product_id = ? ORDER BY id DESC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
