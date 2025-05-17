<?php
// controllers/ReviewController.php
require_once "models/Review.php";

// Ví dụ ReviewController.php
class ReviewController {
    private $model;

    public function __construct() {
        $this->model = new ReviewModel((new Database())->getConnection());
    }

    public function getReviews() {
        $productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $reviews = $this->model->getReviewsByProductId($productId);

        if (empty($reviews)) {
            echo "<p>Chưa có đánh giá nào cho sản phẩm này.</p>";
            return;
        }

        foreach ($reviews as $r) {
            // Kiểm tra xem các khóa có tồn tại không trước khi sử dụng
            $user = isset($r['user']) ? htmlspecialchars($r['user']) : 'Người dùng không xác định';
            $comment = isset($r['comment']) ? nl2br(htmlspecialchars($r['comment'])) : 'Không có bình luận';
            $rating = isset($r['rating']) ? $r['rating'] : 'Chưa đánh giá';

            echo "<div class='mb-3 p-3 border rounded'>";
            echo "<strong>{$user}</strong><br>";
            echo "<p>{$comment}</p>";
            echo "<small>Đánh giá: {$rating} / 5</small>";
            echo "</div>";
        }
    }
}

?>
