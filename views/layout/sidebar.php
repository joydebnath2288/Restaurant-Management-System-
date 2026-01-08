<div class="sidebar">
    <h3>Menu</h3>
    <ul>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=overview">Overview</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=menu&action=manage">Manage Menu</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=order&action=manage">Manage Orders</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=reservation&action=index">Reservations</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=inventory&action=index">Inventory</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=employee&action=index">Employees</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=report&action=index">Reports</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=promotion&action=index">Promotions</a></li>
        <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] == 'staff'): ?>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=dashboard&action=index">Overview</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=order&action=manage">Orders</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=reservation&action=manage">Reservations</a></li>
        <?php else: ?>
            <!-- Customer -->
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=dashboard&action=index">My Dashboard</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=order&action=history">Order History</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=reservation&action=index">My Reservations</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=profile&action=index">My Profile</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=wishlist&action=index">My Wishlist</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=notification&action=index">Notifications</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php?controller=feedback&action=index">Feedback</a></li>
        <?php endif; ?>
    </ul>
</div>

<style>
/* Simple sidebar styles inline for now, can move to css later */
.sidebar {
    float: left;
    width: 20%;
    background: #333;
    color: #fff;
    min-height: 400px;
    padding: 10px;
    box-sizing: border-box;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar li {
    padding: 10px;
    border-bottom: 1px solid #444;
}

.sidebar a {
    color: #fff;
    text-decoration: none;
}

.main-content {
    float: right;
    width: 80%;
    padding: 20px;
    box-sizing: border-box;
}
</style>
