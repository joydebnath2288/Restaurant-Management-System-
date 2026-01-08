<!-- views/admin/order_list.php -->
<style>
    .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .order-table th, .order-table td {
        border: 1px solid #d21616ff;
        padding: 12px;
        text-align: left;
    }
    .order-table th {
        background-color: #343a40;
        color: white;
        text-transform: uppercase;
        font-size: 0.9em;
    }
    .order-table tr:nth-child(even) {
        background-color: #c41818ff;
    }
    .order-table tr:hover {
        background-color: #d61717ff;
    }
    .button.secondary {
        background-color: #6c757d;
        color: white !important;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.85em;
        text-decoration: none;
        transition: background 0.3s;
    }
    .button.secondary:hover {
        background-color: #5a6268;
    }
    .button.danger {
        background-color: #dc3545;
        color: white !important;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.85em;
        text-decoration: none;
        transition: background 0.3s;
    }
    .button.danger:hover {
        background-color: #c82333;
    }
</style>
<h2>Manage Orders</h2>
<table class="order-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orders as $order): ?>
        <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
            <td><?php echo htmlspecialchars($order['status']); ?></td>
            <td><?php echo $order['created_at']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
