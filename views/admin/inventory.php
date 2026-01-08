<h2>Inventory Management</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Last Updated</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($inventory_items as $item): ?>
        <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
            <td style="<?php echo ($item['quantity'] < $item['low_stock_threshold']) ? 'color:red;font-weight:bold;' : ''; ?>">
                <?php echo $item['quantity']; ?>
            </td>
            <td><?php echo htmlspecialchars($item['unit']); ?></td>
            <td><?php echo $item['last_updated']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
