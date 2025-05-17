<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <title>Chi tiết sản phẩm</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            padding: 2rem;
            background: #f8f9fa;
        }

        .product-detail {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
            padding: 2rem;
            margin-top: 2rem;
        }

        h2 {
            margin-bottom: 1rem;
        }

        .btn-add-cart,
        .btn-view-reviews {
            margin-top: 1rem;
            margin-right: 1rem;
        }

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        #product-reviews {
            margin-top: 2rem;
            padding: 1rem;
            background: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        // require_once "config/db.php";

        // $id = $_GET['id'] ?? 0;
        // $stmt = $pdo->prepare("SELECT name, description, price, stock, image FROM products WHERE id = ?");
        // $stmt->execute([$id]);
        // $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product): ?>
            <div class="product-detail">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <?php if (!empty($product['image'])): ?>
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                <?php endif; ?>
                <p><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>
                <p><strong>Giá:</strong> <?= htmlspecialchars($product['price']) ?> VND</p>
                <p><strong>Tồn kho:</strong> <?= htmlspecialchars($product['stock']) ?></p>

                <button class="btn btn-success btn-add-cart" onclick="addToCart(<?= $product['id'] ?>)">
                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                </button>

                <button class="btn btn-outline-primary btn-view-reviews" onclick="fetchReviews(<?= $product['id'] ?>)">
                    <i class="bi bi-chat-dots"></i> Xem đánh giá
                </button>
            </div>

            <!-- Vùng hiển thị đánh giá -->
            <div id="product-reviews">
                <em>Đánh giá sản phẩm sẽ hiển thị tại đây...</em>
            </div>
        <?php else: ?>
            <p class="text-danger">Sản phẩm không tồn tại.</p>
        <?php endif; ?>

        <input type="text" id="search-input" placeholder="Tìm kiếm sản phẩm..." />
        <div id="search-results"></div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script AJAX -->
    <script>
        function addToCart(id) {
            fetch('index.php?act=add_to_cart', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ productId: id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Thêm vào giỏ thành công!');
                } else {
                    alert('Lỗi: ' + data.message);
                }
            });
        }

        function fetchReviews(id) {
            fetch('index.php?act=get_reviews&id=' + id)
                .then(response => response.text()) // Lấy phản hồi dưới dạng HTML
                .then(html => {
                    document.getElementById('product-reviews').innerHTML = html; // Cập nhật vùng hiển thị đánh giá
                })
                .catch(err => {
                    document.getElementById('product-reviews').innerHTML = "<p class='text-danger'>Không thể tải đánh giá.</p>";
                });
        }

        document.getElementById('search-input').addEventListener('input', function() {
            const query = this.value;
            fetch('index.php?act=search&keyword=' + query)
                .then(res => res.json())
                .then(data => {
                    let resultsHtml = '';
                    data.forEach(product => {
                        resultsHtml += `<div>${product.name} - ${product.price} VND</div>`;
                    });
                    document.getElementById('search-results').innerHTML = resultsHtml;
                });
        });
    </script>
</body>

</html>
