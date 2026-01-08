<!-- views/customer/feedback.php -->
<!-- Usually a modal or separate page triggered from Order History -->
<h3>Leave Feedback for Order #<?php echo $_GET['order_id']; ?></h3>
    <form action="<?php echo BASE_URL; ?>index.php?controller=feedback&action=submit" method="POST">
        <label>Order ID (Optional):</label>
        <input type="number" name="order_id" value="<?php echo $_GET['order_id']; ?>"><br>
    
    <label>Rating:</label>
    <select name="rating">
        <option value="5">5 - Excellent</option>
        <option value="4">4 - Good</option>
        <option value="3">3 - Average</option>
        <option value="2">2 - Poor</option>
        <option value="1">1 - Terrible</option>
    </select>
    
    <label>Comment:</label>
    <textarea name="comment" required></textarea>
    
    <button type="submit">Submit Feedback</button>
</form>
