<?php if (empty($reviews)): ?>
    <p>Chưa có đánh giá nào.</p>
<?php else: ?>
    <ul>
    <?php foreach($reviews as $r): ?>
        <li>
            <strong><?=htmlspecialchars($r['username'])?></strong> - 
            <?= $r['rating'] ?>/5 <br>
            <?= htmlspecialchars($r['comment']) ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
