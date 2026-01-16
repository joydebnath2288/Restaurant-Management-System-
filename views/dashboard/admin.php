<?php 
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Order.php';
require_once 'models/Bill.php';

global $conn;

$userModel = new User($conn);
$orderModel = new Order($conn);
$billModel = new Bill($conn);

$totalUsers = $userModel->countUsers();
$totalOrders = $orderModel->countOrders();
$totalRevenue = $billModel->countRevenue();
$activeTables = $orderModel->countActiveOrders();
?>
<?php include 'views/layouts/header.php'; ?>

<h2>Admin Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['full_name']; ?> (Admin)</p>

<div class="dashboard-menu">
    <h3>Overview</h3>
    <div class="flex-row">
        <div class="card">
            <h3>Total Users</h3>
            <p class="fs-2em"><?php echo $totalUsers; ?></p>
        </div>
        <div class="card">
            <h3>Total Orders</h3>
            <p class="fs-2em"><?php echo $totalOrders; ?></p>
        </div>
        <div class="card">
            <h3>Revenue</h3>
            <p class="fs-2em">BDT <?php echo number_format($totalRevenue, 2); ?></p>
        </div>
        <div class="card">
            <h3>Active Tables</h3>
            <p class="fs-2em"><?php echo $activeTables; ?></p>
        </div>
    </div>
</div>


<div class="dashboard-reports mt-30">
    <h3>Sales Reports</h3>
    
    <div class="mb-20">
        <form action="/WT_RMS/admin/reports/export" method="get" target="_blank" class="inline-block">
            <label>From: <input type="date" name="start_date" value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>"></label>
            <label>To: <input type="date" name="end_date" value="<?php echo date('Y-m-d'); ?>"></label>
            <button type="submit" class="btn">Export CSV</button>
        </form>
    </div>

    <div class="flex-row">
        <div class="chart-box">
            <h4>Daily Sales (Last 30 Days)</h4>
            <canvas id="dailySalesChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch('/WT_RMS/api/sales')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            renderDailyChart(data.daily);
        }
    });

    function renderDailyChart(data) {
        const labels = data.map(item => item.date);
        const amounts = data.map(item => item.total);

        new Chart(document.getElementById('dailySalesChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales (BDT)',
                    data: amounts,
                    borderColor: '#28a745',
                    fill: false
                }]
            }
        });
    }
});
</script>

<h3>Actions</h3>
<ul>
    <li><a href="#">Manage Users</a></li>
    <li><a href="/WT_RMS/orders">Manage Orders</a></li>
    <li><a href="/WT_RMS/reservations">View Reservations</a></li>
</ul>



<?php include 'views/layouts/footer.php'; ?>
