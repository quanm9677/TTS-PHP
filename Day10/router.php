<?php
// router.php
$act = strtolower($_GET['act'] ?? 'product_list');

$routes = [
    'product_list' => 'ProductController',
    'product_detail' => 'ProductController',
    'add_to_cart' => 'CartController',
    'get_cart_count' => 'CartController',
    'get_reviews' => 'ReviewController',
    'brands' => 'BrandController',
    'search' => 'SearchController',
    'poll_vote' => 'PollController',
    'poll_result' => 'PollController',
];

if (isset($routes[$act])) {
    $controllerName = $routes[$act];
    $controllerFile = "controllers/{$controllerName}.php";

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controller = new $controllerName();

        // map hành động theo $act (ví dụ)
        switch ($act) {
            case 'product_list':
                $controller->list();
                break;
            case 'product_detail':
                $controller->detail();
                break;
            case 'add_to_cart':
                $controller->add();
                break;
            case 'get_cart_count':
                $controller->count();
                break;
            case 'get_reviews':
                $controller->getReviews();
                break;
            case 'brands':
                $controller->getByCategory();
                break;
            case 'search':
                $controller->search();
                break;
            case 'poll_vote':
                $controller->vote();
                break;

            case 'poll_result':
                $controller->result();
                break;
        }
    } else {
        http_response_code(404);
        echo "Controller không tồn tại.";
    }
} else {
    echo "Action không hợp lệ.";
}
