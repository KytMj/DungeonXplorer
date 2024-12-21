<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
</head>
<body>
    <h1>Inventory</h1>
    <table border="1">
        <tr>
            <th>Item Name</th>
            <th>Description</th>
            <th>Quantity</th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['ite_name']); ?></td>
                <td><?= htmlspecialchars($item['ite_description']); ?></td>
                <td><?= htmlspecialchars($item['inv_quantity']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
