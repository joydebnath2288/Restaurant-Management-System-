<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Smart Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/auth_check.js"></script>
</head>

<body>
    <nav style="background:#333; color:#fff; padding: 1rem; display:flex; justify-content:space-between;">
        <div class="logo">Smart Restaurant</div>
        <div>
            <span>Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User'; ?></span>
            <button onclick="logout()" class="btn" style="padding:5px 10px; margin-left:10px; background:red;">Logout</button>
        </div>
    </nav>

    <div class="container">
        <h1>Welcome to Dashboard</h1>
        <p>Manage your restaurant operations efficiently.</p>

        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
            <div class="card">
                <h3>Customer Profiles</h3>
                <p>Manage customer details.</p>
                <a href="index.php?controller=customer" class="btn">Go to Profiles</a>
            </div>
            <div class="card">
                <h3>Order History</h3>
                <p>View past orders and reservations.</p>
                <a href="index.php?controller=history" class="btn">View History</a>
            </div>
            <div class="card">
                <h3>Employees</h3>
                <p>Manage staff and shifts.</p>
                <a href="index.php?controller=employee" class="btn">Manage Staff</a>
            </div>
            <div class="card">
                <h3>Promotions</h3>
                <p>Create and manage coupons.</p>
                <a href="index.php?controller=promotion" class="btn">Manage Promos</a>
            </div>
        </div>
    </div>


    <script>
        function logout() {
            fetch('index.php?controller=auth&action=logout', {
                method: 'POST' // or GET, controller supports generic but let's be safe
            })
            .then(res => res.json())
            .then(data => {
                 if(data.redirect) window.location.href = data.redirect;
            })
            .catch(err => console.error(err));
        }
    </script>
 
</body>

</html>
