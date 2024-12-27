<?php if (!empty($inventory)): ?>
    <ul>
        <?php foreach ($inventory as $item): ?>
            <li>
                <strong><?= htmlspecialchars($item['ite_name']) ?> (x<?= htmlspecialchars($item['inven_quantity']) ?>)</strong>
                <p><?= htmlspecialchars($item['ite_description']) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>L'inventaire est vide.</p>
<?php endif; ?>
        
