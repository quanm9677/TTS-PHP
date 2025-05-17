<?php
// controllers/SearchController.php
require_once "models/Product.php";

class SearchController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function search() {
        $keyword = $_GET['keyword'] ?? '';
        $products = $this->productModel->search($keyword);
        echo json_encode($products); // Trả về danh sách sản phẩm dưới dạng JSON
    }
}
?>
