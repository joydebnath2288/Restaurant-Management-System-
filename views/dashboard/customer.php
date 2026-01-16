<?php 
require_once 'config/database.php';
require_once 'models/Order.php';
global $conn;
$orderModel = new Order($conn);
$myOrders = $orderModel->getByCustomer($_SESSION['user_id']);
?>
<?php include 'views/layouts/header.php'; ?>

<h2>Customer Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['full_name']; ?>!</p>

<div class="dashboard-menu">
    <h3>My Orders</h3>
    <?php if (empty($myOrders)): ?>
        <p>No orders found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($myOrders as $order): ?>
                <li>
                    <strong>Order #<?php echo $order['id']; ?></strong> - 
                    <span class="<?php echo $order['status']=='pending'?'text-red':'text-green'; ?>"><?php echo ucfirst($order['status']); ?></span>
                    <br><small>Items: <?php echo $order['items']; ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <div id="dynamic-orders-list"></div>
</div>

<script>
let previousStatuses = {};

function fetchCustomerOrders() {
    fetch('/WT_RMS/api/my-orders-customer')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            updateOrderList(data.data);
        }
    })
    .catch(err => console.error("Polling error:", err));
}

function updateOrderList(orders) {
    let html = '<ul>';
    if (orders.length === 0) {
        html = '<p>No orders found (Live).</p>';
    } else {
        orders.forEach(order => {
             if (previousStatuses[order.id] && previousStatuses[order.id] !== order.status) {
                 alert(`Order #${order.id} status changed to ${order.status}!`);
             }
             previousStatuses[order.id] = order.status;

             previousStatuses[order.id] = order.status;

             let colorClass = (order.status === 'pending') ? 'text-red' : 'text-green';
             html += `<li>
                <strong>Order #${order.id}</strong> - 
                <span class="${colorClass}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span>
                <br><small>Items: ${order.items}</small>
             </li>`;
        });
        html += '</ul>';
    }
    
    document.getElementById('dynamic-orders-list').innerHTML = html;
    
    let staticList = document.querySelector('.dashboard-menu > ul');
    if(staticList) staticList.style.display = 'none';
    let staticPara = document.querySelector('.dashboard-menu > p');
    if(staticPara && staticPara.innerText.includes('No orders')) staticPara.style.display = 'none';
}

setInterval(fetchCustomerOrders, 5000);
fetchCustomerOrders();
</script>

<h3>Actions</h3>
<ul>
    <li><a href="/WT_RMS/reserve">Reserve a Table</a></li>
    <li><a href="#">Order Food Online (Coming Soon)</a></li>
</ul>



<?php include 'views/layouts/footer.php'; ?>
