<?php
session_start();
require_once "../models/Announcement.php";
$announcements = announcementGetAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Announcements</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="feature-announce">

<div class="box">
    <?php if (isset($_SESSION['role'])): ?>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="dashboard.php" class="nav-back">← Back to Dashboard</a>
        <?php else: ?>
            <a href="customer_dashboard.php" class="nav-back">← Back to Dashboard</a>
        <?php endif; ?>
    <?php else: ?>
        <a href="login.php" class="nav-back">← Back to Login</a>
    <?php endif; ?>

    <h3>Restaurant Announcements</h3>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; text-align: center;"><?php echo "Announcement Added Successfully"; ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <form action="../controllers/Announcement.php" method="POST">
        
        <label>Announcement Title:</label>
        <input type="text" name="title" placeholder="e.g. Special Offer" required>

        <label>Announcement Type:</label>
        <select name="type" required>
            <option value="">Select type</option>
            <option value="Offer">Offer</option>
            <option value="Notice">Notice</option>
            <option value="Out of Stock">Out of Stock</option>
            <option value="General">General</option>
        </select>

        <label>Message:</label>
        <textarea name="message" rows="5" placeholder="Write announcement details" required></textarea>

        <div style="margin-top: 15px;">
            <button type="submit">Add Announcement</button>
            <button type="reset" style="background-color: #6c757d;">Clear</button>
        </div>

    </form>
    <?php endif; ?>
</div>

<div class="box" style="margin-top: 20px;">
    <h3>Saved Announcements</h3>
    <div id="announceList">
        <?php
        if (!empty($announcements)) {
            foreach ($announcements as $row) {
                echo "<div class='announce-item' style='border-bottom:1px solid #ccc; padding:10px; margin-bottom:10px;'>";
                echo "<strong>" . htmlspecialchars($row['title']) . "</strong> ";
                
                if (isset($row['created_at'])) {
                    echo "<small>(" . $row['created_at'] . ")</small><br>";
                } else {
                     echo "<br>";
                }

                echo "Type: " . htmlspecialchars($row['type']) . "<br>";
                echo htmlspecialchars($row['message']);

                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                     echo "<div style='margin-top:10px;'>";
                     echo "<a href='../controllers/Announcement.php?delete=" . $row['id'] . "' class='delete-btn' style='background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 14px;'>Delete</a>";
                     echo "</div>";
                }

                echo "</div>";
            }
        } else {
            echo "No announcements yet.";
        }
        ?>
    </div>
</div>

</body>
</html>
