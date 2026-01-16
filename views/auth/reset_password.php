<?php include 'views/layouts/header.php'; ?>

<div class="auth-container" style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h2 style="text-align: center;">Reset Password</h2>
    <form id="resetPasswordForm">
        <input type="hidden" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <input type="hidden" id="token" name="token" value="<?php echo htmlspecialchars($token); ?>">
        
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; margin: 10px 0;">
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required style="width: 100%; padding: 8px; margin: 10px 0;">
        
        <button type="submit" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; cursor: pointer;">Reset Password</button>
    </form>
    <div id="message" style="margin-top: 15px; text-align: center;"></div>
</div>

<script>
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    fetch('/WT_RMS/reset-password', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        var msgDiv = document.getElementById('message');
        msgDiv.innerText = data.message;
        if (data.status === 'success') {
            msgDiv.style.color = 'green';
            setTimeout(function() {
                window.location.href = '/WT_RMS/login';
            }, 2000);
        } else {
            msgDiv.style.color = 'red';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>

<?php include 'views/layouts/footer.php'; ?>
