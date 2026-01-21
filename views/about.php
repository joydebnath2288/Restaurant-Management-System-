<?php
session_start();
$file = "../config/about_data.json";
$aboutData = ["name" => "Restaurant Name", "desc" => "Short description"];

if (file_exists($file)) {
    $temp = json_decode(file_get_contents($file), true);
    if ($temp) {
        $aboutData = $temp;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>About Us</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="feature-about">

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

    <h2>About Us</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; text-align: center;"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>

    <div id="aboutSection" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f9f9f9; border-radius: 4px;">
        <h3><?php echo htmlspecialchars($aboutData['name']); ?></h3>
        <p><?php echo htmlspecialchars($aboutData['desc']); ?></p>
    </div>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <form action="../controllers/About.php" method="POST" id="aboutForm">
        <h3>Update Details</h3>

        <label for="resName">Restaurant Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($aboutData['name']); ?>" required>

        <label for="shortDesc">Short Description</label>
        <textarea name="desc" rows="3" required><?php echo htmlspecialchars($aboutData['desc']); ?></textarea>

        <button type="submit">Update</button>
    </form>
    <?php endif; ?>
</div>

<div class="box" style="margin-top: 20px; max-width: 800px;">
    <h3>Our Team</h3>
    
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <div style="margin-bottom: 20px; text-align: right;">
        <button onclick="document.getElementById('addMemberForm').style.display='block'" style="width: auto; padding: 10px;">+ Add New Member</button>
    </div>

    <div id="addMemberForm" style="display:none; background: #f1f5f9; padding: 20px; border-radius: 4px; margin-bottom: 20px; text-align: left;">
        <h4>Add Team Member</h4>
        <form action="../controllers/Team.php" method="POST" enctype="multipart/form-data">
            
            <label>Name</label>
            <input type="text" name="name" required>

            <label>Role</label>
            <input type="text" name="role" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Phone</label>
            <input type="text" name="phone" required>

            <label>Image</label>
            <input type="file" name="image" required accept="image/*">

            <button type="submit">Save Member</button>
            <button type="button" onclick="document.getElementById('addMemberForm').style.display='none'" style="background: #94a3b8; margin-top: 10px;">Cancel</button>
        </form>
    </div>
    <?php endif; ?>

    <div class="team-row">
        <?php
        require_once "../models/Team.php";
        $teamMembers = teamGetAll();

        if (empty($teamMembers)) {
            echo "<p>No team members found.</p>";
        } else {
            foreach ($teamMembers as $member) {
                ?>
                <div class="team-box">
                    <?php if (!empty($member['image'])): ?>
                        <img src="../public/images/<?php echo htmlspecialchars($member['image']); ?>" class="team-img" alt="<?php echo htmlspecialchars($member['role']); ?>">
                    <?php else: ?>
                        <div class="team-img" style="background: #ccc; display: flex; align-items: center; justify-content: center;">No Img</div>
                    <?php endif; ?>
                    
                    <h4><?php echo htmlspecialchars($member['role']); ?></h4>
                    <p>Name: <?php echo htmlspecialchars($member['name']); ?></p>
                    <p>Email: <?php echo htmlspecialchars($member['email']); ?></p>
                    <p>Contact no: <?php echo htmlspecialchars($member['phone']); ?></p>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <div style="margin-top: 15px;">
                            <button onclick='showUpdateForm(<?php echo json_encode($member); ?>)' style="width: auto; padding: 5px 10px; font-size: 14px;">Update</button>
                            <a href="../controllers/Team.php?delete=<?php echo $member['id']; ?>" class="delete-btn" style="background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 14px;">Delete</a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <div id="updateMemberForm" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div class="box" style="margin: 50px auto; max-width: 500px; position: relative;">
            <h3>Update Member</h3>
            <form action="../controllers/Team.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="upd-id">
                <input type="hidden" name="current_image" id="upd-current-image">

                <label>Name</label>
                <input type="text" name="name" id="upd-name" required>

                <label>Role</label>
                <input type="text" name="role" id="upd-role" required>

                <label>Email</label>
                <input type="email" name="email" id="upd-email" required>

                <label>Phone</label>
                <input type="text" name="phone" id="upd-phone" required>

                <label>Image (Leave empty to keep current)</label>
                <input type="file" name="image" accept="image/*">
                
                <button type="submit">Update</button>
                <button type="button" onclick="document.getElementById('updateMemberForm').style.display='none'" style="background: #94a3b8; margin-top: 10px;">Cancel</button>
            </form>
        </div>
    </div>

    <script>
    function showUpdateForm(member) {
        document.getElementById("upd-id").value = member.id;
        document.getElementById("upd-name").value = member.name;
        document.getElementById("upd-role").value = member.role;
        document.getElementById("upd-email").value = member.email;
        document.getElementById("upd-phone").value = member.phone;
        document.getElementById("upd-current-image").value = member.image;
        document.getElementById("updateMemberForm").style.display = "block";
    }
    </script>
    <?php endif; ?>
</div>

</body>
</html>
