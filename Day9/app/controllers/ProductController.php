<?php
require_once '../models/Product.php';

class ProductController
{
    public function index()
    {
        $products = Product::all();
        require '../views/product/products.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'product_name' => $_POST['product_name'],
                'unit_price' => $_POST['unit_price'],
                'stock_quantity' => $_POST['stock_quantity'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            Product::create($data);
            header("Location: ?act=products");
            exit();
        } else {
            header("Location: ?act=add-product");
            exit();
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            Product::delete($_GET['id']);
            header("Location: ?act=products");
            exit();
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $data = [
                'product_name' => $_POST['product_name'],
                'unit_price' => $_POST['unit_price'],
                'stock_quantity' => $_POST['stock_quantity']
            ];
            Product::update($_POST['id'], $data);
            header("Location: ?act=products");
            exit();
        }
    }

    public function view()
    {
        if (isset($_GET['id'])) {
            $product = Product::find($_GET['id']);
            require '../views/product/product_detail.php';
        }
    }

    public function add()
    {
        require '../views/product/add_product.php';
    }

    // ✅ Hiển thị form sửa sản phẩm
    public function edit()
    {
        if (isset($_GET['id'])) {
            $product = Product::find($_GET['id']);
            if ($product) {
                require '../views/product/edit_product.php';
                return;
            }
        }
        echo "Không tìm thấy sản phẩm.";
    }

    public function filterByPrice() {
        $products = Product::filterByPrice(1000000); // Lọc sản phẩm có giá > 1.000.000 VNĐ
        require '../views/product/products.php'; // Hiển thị danh sách sản phẩm đã lọc
    }

    public function orderByPriceDesc() {
        $products = Product::orderByPriceDesc(); // Lấy sản phẩm theo giá giảm dần
        require '../views/product/products.php'; // Hiển thị danh sách sản phẩm đã sắp xếp
    }
}
?>
