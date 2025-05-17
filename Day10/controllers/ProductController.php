<?php
// controllers/ProductController.php
require_once "models/Product.php";

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function list() {
        $products = $this->productModel->getAll();
        require "views/products/list.php";
    }

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getById($id);
        require "views/products/detail.php"; // Tách view thay vì echo trực tiếp
    }
    
}
?>
