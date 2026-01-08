<!-- views/admin/gallery.php -->
<div class="card">
    <h3>Add New Photo</h3>
    <form action="<?php echo BASE_URL; ?>index.php?controller=gallery&action=add" method="POST" enctype="multipart/form-data">
        <label>Select Image:</label>
        <input type="file" name="image" required accept="image/*"><br><br>
        
        <label>Description:</label>
        <textarea name="description" placeholder="Enter image description" required></textarea><br><br>
        
        <button type="submit">Upload Photo</button>
    </form>
</div>

<h3>Current Gallery</h3>
<div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
    <?php if(!empty($images)): ?>
        <?php foreach($images as $img): ?>
            <div class="gallery-item" style="border:1px solid #ddd; padding:10px; border-radius:8px;">
                <?php $imgSrc = isset($img['image']) ? $img['image'] : 'default.jpg'; ?>
                <img src="<?php echo BASE_URL; ?>public/uploads/gallery/<?php echo $imgSrc; ?>" alt="Gallery Image" style="width:100%; height:150px; object-fit:cover; border-radius:5px;">
                <p><?php echo isset($img['description']) ? htmlspecialchars($img['description']) : 'No description'; ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No images in gallery.</p>
    <?php endif; ?>
</div>
