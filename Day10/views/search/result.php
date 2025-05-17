<?php if (empty($products)): ?>
    <p>Không tìm thấy sản phẩm phù hợp.</p>
<?php else: ?>
    <ul class="list-group">
    <?php foreach($products as $p): ?>
        <li class="list-group-item d-flex align-items-center">
            <img src="<?= htmlspecialchars($p['image'] ?: 'assets/placeholder.jpg') ?>" width="50" height="50" alt="<?= htmlspecialchars($p['name']) ?>" class="me-3" />
            <div>
                <?= htmlspecialchars($p['name']) ?> - <?= number_format($p['price']) ?> VND
            </div>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
