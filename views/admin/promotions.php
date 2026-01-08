<h2>Manage Promotions</h2>

<div class="card">
    <h3>Add New Promotion</h3>
    <form action="<?php echo BASE_URL; ?>index.php?controller=promotion&action=store" method="POST">
        <input type="text" name="code" placeholder="Promo Code (e.g. SUMMER10)" required>
        <input type="number" name="discount" placeholder="Discount %" required>
        <input type="date" name="valid_until" required>
        <button type="submit">Create Promotion</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Discount (%)</th>
            <th>Valid Until</th>
            <th>Active</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($promotions as $promo): ?>
        <tr>
            <td><?php echo $promo['id']; ?></td>
            <td><?php echo htmlspecialchars($promo['code']); ?></td>
            <td><?php echo $promo['discount_percent']; ?>%</td>
            <td><?php echo $promo['valid_until']; ?></td>
            <td><?php echo $promo['is_active'] ? 'Yes' : 'No'; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>index.php?controller=promotion&action=delete&id=<?php echo $promo['id']; ?>" class="button danger" onclick="return confirm('Delete?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
