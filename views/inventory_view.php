<?php if (!empty($inventory)): ?>
    <style>
.inventory-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.inventory-table th, .inventory-table td{
    padding: 10px;
    border: 1px solid #ddd;
}

/*"Item" & "Quantité" */
.inventory-table th:first-child, .inventory-table td:first-child {
    background-color: #C4975E;
    color: white;
    font-weight: bold;
    text-align : center;
}


/* other columns */
.inventory-table td:not(:first-child) {
    background-color: #2E2E2E;
    color: white;
}

/* hover for items*/
.inventory-table tr:hover td:not(:first-child) {
    background-color: #4A7A66; /*vert*/
}


    </style>
    <table class="inventory-table">
        <thead>
            <tr>
                <th>Item</th>
                <?php foreach ($inventory as $item): ?>
                    <th><?= htmlspecialchars($item['ite_name'] ?? 'No Name') ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Quantité</strong></td>
                <?php foreach ($inventory as $item): ?>
                    <td><?= htmlspecialchars($item['inven_quantity'] ?? 0) ?></td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <p>L'inventaire est vide.</p>
<?php endif; ?>
