<?php include 'views/layouts/header.php'; ?>

<div class="dashboard-container">
    <h2>Staff Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION['full_name']; ?></p>

    <div class="cards-wrapper" style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div class="card" style="flex: 1; padding: 20px; background: #e3f2fd; border-radius: 8px;">
            <h3>Active Orders</h3>
            <p id="active-count" style="font-size: 2em; margin: 0;">0</p>
        </div>
        <div class="card" style="flex: 1; padding: 20px; background: #fff3e0; border-radius: 8px;">
            <h3>Pending Tasks</h3>
            <p id="pending-count" style="font-size: 2em; margin: 0;">0</p>
        </div>
    </div>

    <h3>Assigned Orders</h3>
    <div id="orders-list">
        <p>Loading...</p>
    </div>

</div>

<script>
function fetchOrders() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "api/my-orders", true);
    
    xhr.onload = function() {
        if (xhr.status == 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.status == "success") {
                    updateDashboard(response.data, response.stats);
                }
            } catch(e) {
                console.error("Parsing error", e);
            }
        }
    };
    xhr.send();
}

function updateDashboard(orders, stats) {
    document.getElementById('active-count').innerText = stats.active_orders || 0;
    document.getElementById('pending-count').innerText = stats.pending_tasks || 0;

    var html = '<table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">';
    html += '<tr><th>ID</th><th>Customer</th><th>Items</th><th>Status</th><th>Time</th></tr>';

    if (orders.length === 0) {
        html += '<tr><td colspan="5">No active orders assigned to you.</td></tr>';
    } else {
        orders.forEach(function(order) {
            html += `<tr>
                <td>${order.id}</td>
                <td>${order.customer_name}</td>
                <td>${order.items}</td>
                <td>${order.status}</td>
                <td>${order.created_at}</td>
            </tr>`;
        });
    }
    html += '</table>';
    
    document.getElementById('orders-list').innerHTML = html;
}

fetchOrders();

setInterval(fetchOrders, 5000);
</script>

<?php include 'views/layouts/footer.php'; ?>
