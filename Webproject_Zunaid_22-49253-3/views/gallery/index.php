<!DOCTYPE html>
<html>
<head>
    <title>Menu Gallery</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="feature-gallery">

<div class="box">
    <?php if (isset($_SESSION['status']) || isset($_COOKIE['status'])): ?>
        <a href="index.php?controller=dashboard&action=index" class="nav-back">← Back to Dashboard</a>
    <?php else: ?>
        <a href="index.php?controller=auth&action=login" class="nav-back">← Back to Login</a>
    <?php endif; ?>

    <h2>Menu Gallery</h2>

    <?php if (isset($_SESSION['status']) || isset($_COOKIE['status'])): ?>
    <form method="post" 
          action="index.php?controller=gallery&action=save"
          enctype="multipart/form-data">

        <label>Image Title</label>
        <input type="text" name="title" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Select Image (JPG, PNG, GIF - Max 5MB)</label>
        <input type="file" name="image" required>

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
                     <img src="uploads/gallery/<?php echo htmlspecialchars($img['image']); ?>" width="200" style="margin: 10px 0; border-radius: 4px;"><br>
                <?php endif; ?>
                <p><?php echo htmlspecialchars($img['description']); ?></p>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No images found.</p>
    <?php } ?>
</div>

</body>
</html>
