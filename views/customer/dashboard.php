<h3>My Dashboard</h3>
<p>Welcome, <b><?php echo $_SESSION['user_name']; ?></b>!</p>
<div class="card">
    <h4>Recent Activity</h4>
    <p>You have no recent orders.</p>
    <a href="<?php echo BASE_URL; ?>index.php?page=home&action=menu" class="btn">Order Now</a>
</div>
