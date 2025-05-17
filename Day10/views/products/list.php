    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8" />
        <title>Danh sách sản phẩm</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <style>
            body {
                padding: 2rem;
                background: #f8f9fa;
            }

            h1 {
                margin-bottom: 1rem;
            }

            .price {
                font-weight: 700;
                color: #23363a;
            }

            #cart-count {
                font-weight: 700;
                color: #0d6efd;
            }

            #product-reviews {
                margin-top: 2rem;
                padding: 1rem;
                background: #ffffff;
                border-radius: 0.5rem;
                box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
                min-height: 100px;
            }

            table thead {
                background-color: #2d9d63;
                color: white;
            }

            .search-controls {
                margin-bottom: 1.5rem;
            }

            #search-results div {
                padding: 4px 0;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1 class="text-primary">Danh sách sản phẩm</h1>

            <div class="mb-3">
                Giỏ hàng: <span id="cart-count">0</span> sản phẩm
            </div>

            <!-- Bộ lọc và tìm kiếm -->
            <div class="row search-controls align-items-end">
                <div class="col-md-3 mb-2">
                    <label for="category-select" class="form-label">Ngành hàng</label>
                    <select id="category-select" class="form-select">
                        <option value="">-- Chọn ngành hàng --</option>
                        <option value="Điện tử">Điện tử</option>
                        <option value="Thời trang">Thời trang</option>
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label for="brand-select" class="form-label">Thương hiệu</label>
                    <select id="brand-select" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>
                    </select>
                </div>

                <div class="col-md-6 mb-2">
                    <label for="search-input" class="form-label">Tìm kiếm sản phẩm</label>
                    <input type="text" id="search-input" class="form-control" placeholder="Nhập tên sản phẩm...">
                    <div id="search-results" class="mt-1 text-muted small"></div>
                </div>
            </div>

            <!-- Bảng danh sách sản phẩm -->
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td>
                                    <a href="index.php?act=product_detail&id=<?= $p['id'] ?>" class="text-decoration-none text-success fw-semibold">
                                        <?= htmlspecialchars($p['name']) ?>
                                    </a>
                                </td>
                                <td class="price"><?= number_format($p['price'], 2) ?> VND</td>
                                <td>
                                    <button class="btn btn-sm btn-success me-2" onclick="addToCart(<?= $p['id'] ?>)">
                                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary" onclick="fetchReviews(<?= $p['id'] ?>)">
                                        <i class="bi bi-chat-dots"></i> Xem đánh giá
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Khu vực hiển thị đánh giá -->
            <div id="product-reviews" class="mt-4">
                <em>Đánh giá sản phẩm sẽ hiển thị ở đây</em>
            </div>

            <?php include 'views/poll/form.php'; ?>

            <!-- Thêm phần bình chọn vào cuối danh sách sản phẩm -->
            <!-- <div class="poll-section">
                <h3>Bạn muốn cải thiện điều gì trên website?</h3>
                <form id="pollForm">
                    <label><input type="radio" name="option" value="Giao diện"> Giao diện</label><br>
                    <label><input type="radio" name="option" value="Tốc độ"> Tốc độ</label><br>
                    <label><input type="radio" name="option" value="Dịch vụ khách hàng"> Dịch vụ khách hàng</label><br>
                    <button type="submit">Gửi</button>
                </form>
                <div id="pollResult"></div>
            </div> -->

            <!-- Hiển thị kết quả bình chọn -->
            <?php
            require_once 'controllers/PollController.php';
            $poll = new PollController();
            $poll->result();
            ?>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- JS chức năng -->
        <script>
            function addToCart(id) {
                fetch('index.php?act=add_to_cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            productId: id
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('cart-count').textContent = data.cartCount;
                            alert('Thêm vào giỏ thành công!');
                        } else {
                            alert('Lỗi: ' + data.message);
                        }
                    });
            }

            function loadCartCount() {
                fetch('index.php?act=get_cart_count')
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('cart-count').textContent = data.cartCount;
                    });
            }

            function fetchReviews(id) {
                fetch('index.php?act=get_reviews&id=' + id)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('product-reviews').innerHTML = html;
                    });
            }

            // AJAX: chọn ngành hàng -> tải thương hiệu
            document.getElementById('category-select').addEventListener('change', function() {
                const category = this.value;
                fetch('index.php?act=brands&category=' + encodeURIComponent(category))
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('brand-select').innerHTML = html;
                    });
            });

            // AJAX: tìm kiếm sản phẩm
            document.getElementById('search-input').addEventListener('input', debounce(function() {
                const query = this.value.trim();
                if (!query) {
                    document.getElementById('search-results').innerHTML = '';
                    return;
                }

                fetch('index.php?act=search&keyword=' + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(products => {
                        if (products.length === 0) {
                            document.getElementById('search-results').innerHTML = '<p>Không tìm thấy sản phẩm nào</p>';
                            return;
                        }
                        let html = '<ul class="list-group">';
                        products.forEach(p => {
                            html += `<li class="list-group-item d-flex align-items-center">
                <img src="${p.image || 'assets/placeholder.jpg'}" alt="${p.name}" width="50" height="50" class="me-3" />
                <div>${p.name} - ${p.price.toLocaleString()} VND</div>
            </li>`;
                        });
                        html += '</ul>';
                        document.getElementById('search-results').innerHTML = html;
                    });
            }, 300));

            // Hàm debounce để giảm số lần gọi API khi nhập liệu nhanh
            function debounce(fn, delay) {
                let timeoutID;
                return function() {
                    clearTimeout(timeoutID);
                    timeoutID = setTimeout(() => fn.apply(this, arguments), delay);
                }
            }


            // Tải số lượng giỏ hàng ban đầu
            window.onload = loadCartCount;
        </script>
    </body>

    </html>