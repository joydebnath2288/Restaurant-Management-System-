<!-- views/admin/menu_list.php -->
<style>
    .menu-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .menu-table th, .menu-table td {
        border: 1px solid #ce2020ff;
        padding: 12px;
        text-align: left;
    }
    .menu-table th {
        background-color: #343a40;
        color: white;
        text-transform: uppercase;
        font-size: 0.9em;
    }
    .menu-table tr:nth-child(even) {
        background-color: #dc2222ff;
    }
    .menu-table tr:hover {
        background-color: #c01f1fff;
    }
    .button.primary {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        margin-bottom: 15px;
    }
    .button.primary:hover {
        background-color: #0056b3;
    }
</style>
<h2>Manage Menu</h2>
<a href="<?php echo BASE_URL; ?>index.php?controller=menu&action=create" class="button primary">Add New Item</a>
<table class="menu-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($menu_items as $item): ?>
        <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td>BDT<?php echo number_format($item['price'], 2); ?></td>
            <td><?php echo htmlspecialchars($item['category']); ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>index.php?controller=menu&action=delete&id=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
