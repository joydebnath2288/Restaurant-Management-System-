<?php
session_start();
require_once "../models/Gallery.php";
$images = galleryGetAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu Gallery</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="feature-gallery">

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

    <h2>Menu Gallery</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; text-align: center;"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <form action="../controllers/Gallery.php" method="POST" enctype="multipart/form-data">
        <label>Image Title</label>
        <input type="text" name="title" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Select Image (JPG, PNG, GIF - Max 5MB)</label>
        <input type="file" name="image" required accept="image/*">

        <input type="submit" value="Add Image">
    </form>
    <?php endif; ?>
</div>

<div class="box" style="margin-top: 20px;">
    <h3>Gallery Images</h3>

    <?php if (!empty($images)) { ?>
        <?php foreach ($images as $img) { ?>
            <div style="margin-bottom:20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <strong><?php echo htmlspecialchars($img['title']); ?></strong><br>
                <?php if (!empty($img['image'])): ?>
                     <img src="../public/uploads/gallery/<?php echo htmlspecialchars($img['image']); ?>" width="200" style="margin: 10px 0; border-radius: 4px;"><br>
                <?php endif; ?>
                <p><?php echo htmlspecialchars($img['description']); ?></p>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                     <div style='margin-top:10px;'>
                         <a href="../controllers/Gallery.php?delete=<?php echo $img['id']; ?>" class="delete-btn" style="background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; display: inline-block;">Delete</a>
                     </div>
                <?php endif; ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No images found.</p>
    <?php } ?>
</div>

</body>
</html>
