<?php include 'views/layouts/header.php'; ?>

<div class="auth-container" style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h2 style="text-align: center;">Forgot Password</h2>
    <form id="forgotPasswordForm">
        <label for="email">Enter your email address:</label>
        <input type="email" id="email" name="email" required placeholder="example@email.com" style="width: 100%; padding: 8px; margin: 10px 0;">
        
        <button type="submit" style="width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer;">Send Reset Link</button>
    </form>
    <div id="message" style="margin-top: 15px; text-align: center;"></div>
</div>

<script>
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var email = document.getElementById('email').value;
    
    var formData = new FormData();
    formData.append('email', email);

    fetch('/WT_RMS/forgot-password', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        var msgDiv = document.getElementById('message');
        msgDiv.innerText = data.message;
        if (data.status === 'success') {
            msgDiv.style.color = 'green';
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
