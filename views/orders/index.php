<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <h2>Manage Orders</h2>
    <a href="/WT_RMS/dashboard">Back to Dashboard</a>
    <br><br>

    <div id="message"></div>

    <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['customer_name']; ?></td>
                <td><?php echo $order['items']; ?></td>
                <td>
                    <span id="status-<?php echo $order['id']; ?>" style="font-weight:bold; color: <?php echo $order['status'] == 'pending' ? 'red' : 'green'; ?>">
                        <?php echo ucfirst($order['status']); ?>
                    </span>
                </td>
                <td>
                    <select onchange="updateStatus(<?php echo $order['id']; ?>, this.value)">
                        <option value="pending" <?php if($order['status']=='pending') echo 'selected'; ?>>Pending</option>
                        <option value="preparing" <?php if($order['status']=='preparing') echo 'selected'; ?>>Preparing</option>
                        <option value="served" <?php if($order['status']=='served') echo 'selected'; ?>>Served</option>
                        <option value="delivered" <?php if($order['status']=='delivered') echo 'selected'; ?>>Delivered</option>
                    </select>
                    <?php if ($order['status'] == 'served' || $order['status'] == 'delivered'): ?>
                        <br><a href="/WT_RMS/bills/generate?order_id=<?php echo $order['id']; ?>" target="_blank" style="font-size: 0.8em; color: blue;">Generate Bill</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function updateStatus(orderId, newStatus) {
    var formData = new FormData();
    formData.append('order_id', orderId);
    formData.append('status', newStatus);

    var xhr = new XMLHttpRequest();
    // Path needs to match router
    xhr.open("POST", "/WT_RMS/orders/update", true);
    
    xhr.onload = function() {
        if (xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status == "success") {
                document.getElementById('status-' + orderId).innerText = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                 // Optional: alert('Updated!');
            } else {
                alert('Update failed');
            }
        }
    };
    xhr.send(formData);
}
</script>

<?php include 'views/layouts/footer.php'; ?>
