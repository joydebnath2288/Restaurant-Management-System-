<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Announcements</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="feature-announce">

<div class="box">
    <?php if (isset($_SESSION['status']) || isset($_COOKIE['status'])): ?>
        <a href="index.php?controller=dashboard&action=index" class="nav-back">← Back to Dashboard</a>
    <?php else: ?>
        <a href="index.php?controller=auth&action=login" class="nav-back">← Back to Login</a>
    <?php endif; ?>

    <h3>Restaurant Announcements</h3>

    <?php if (isset($_SESSION['status']) || isset($_COOKIE['status'])): ?>
    <form id="announceForm">
        
        <label>Announcement Title:</label>
        <input type="text" id="titleField" name="title" placeholder="e.g. Special Offer">

        <label>Announcement Type:</label>
        <select id="typeField" name="type">
            <option value="">Select type</option>
            <option value="Offer">Offer</option>
            <option value="Notice">Notice</option>
            <option value="Out of Stock">Out of Stock</option>
            <option value="General">General</option>
        </select>

        <label>Message:</label>
        <textarea id="msgField" name="message" rows="5" placeholder="Write announcement details"></textarea>

        <div style="margin-top: 15px;">
            <button type="button" id="addAnnBtn">Add Announcement</button>
            <button type="button" id="clearBtn" style="background-color: #6c757d;">Clear</button>
        </div>

        <p id="message"></p>
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
                echo "</div>";
            }
        } else {
            echo "No announcements yet.";
        }
        ?>
    </div>
</div>

<script src="js/announcement.js"></script>
</body>
</html>
