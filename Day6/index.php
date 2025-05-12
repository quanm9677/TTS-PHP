<?php
session_start();
$books = [
    1 => ['name' => 'Doraemon', 'price' => 100000, 'img' => 'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/c/o/copy_of_250220_dr25_main_b1_localized_embbed_1_.jpg'],
    2 => ['name' => 'Shin cậu bé bút chì', 'price' => 120000, 'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuf0W8lUTamQAFqsYBCW1tQkEnQeaK86Ew0Q&s'],
    3 => ['name' => 'Pokemon', 'price' => 90000, 'img' => 'https://deadline.com/wp-content/uploads/2024/09/Pokemon-Mini-Series-Aim-to-Be-a-Pokemon-Master-Ep-1-11.jpg?w=800'],
    4 => ['name' => 'Naruto', 'price' => 100000, 'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvtctxEKPODXyQW7LjXqqPsBhj7ORiYHsIfg&s'],
    5 => ['name' => 'One Piece', 'price' => 120000, 'img' => 'https://upload.wikimedia.org/wikipedia/vi/c/c7/Naruto_Volume_1_manga_cover.jpg'],
    6 => ['name' => 'One Punch Man ', 'price' => 90000, 'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQw8B43Q0tVmm8hUYYbfgdbFS8sG8ujruWuyg&s']
];
$user_name = $_COOKIE['user_name'] ?? '';
$user_email = $_COOKIE['user_email'] ?? '';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Đặt Sách</title>
    <style>
        body {
            font-family: Arial;
            background: #f6f6f6;
        }

        .container {
            background: #fff;
            max-width: 600px;
            margin: 40px auto;
            padding: 24px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #ccc;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 95%;
            padding: 7px;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .book-row {
            margin-bottom: 8px;
        }

        .book-row label {
            font-weight: normal;
        }

        button {
            margin-top: 18px;
            width: 100%;
            padding: 10px;
            background: #2980b9;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }

        ul {
            color: red;
        }

        .book-list {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 20px;
        }
        .book-card {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 150px;
            padding: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 1px 4px #eee;
        }
        .book-card img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 8px;
        }
        .book-info {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Đặt Sách</h2>
        <?php
        if (isset($_SESSION['errors'])) {
            echo "<ul>";
            foreach ($_SESSION['errors'] as $err) echo "<li>$err</li>";
            echo "</ul>";
            unset($_SESSION['errors']);
        }
        ?>
        <form method="post" action="process_cart.php">
            <label>Chọn sách:</label>
            <div class="book-list">
            <?php foreach ($books as $id => $book): ?>
                <div class="book-card">
                    <img src="<?= htmlspecialchars($book['img']) ?>" alt="<?= htmlspecialchars($book['name']) ?>">
                    <div class="book-info">
                        <input type="checkbox" name="books[]" value="<?= $id ?>" id="book<?= $id ?>">
                        <label for="book<?= $id ?>"><b><?= htmlspecialchars($book['name']) ?></b></label><br>
                        <span>Giá: <b><?= number_format($book['price']) ?>đ</b></span><br>
                        Số lượng: <input type="number" name="quantity[<?= $id ?>]" min="1" value="1" style="width:50px">
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <label>Họ tên:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user_name) ?>">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user_email) ?>">
            <label>Điện thoại:</label>
            <input type="text" name="phone">
            <label>Địa chỉ:</label>
            <input type="text" name="address">
            <button type="submit">Đặt hàng</button>
        </form>
    </div>
</body>

</html>