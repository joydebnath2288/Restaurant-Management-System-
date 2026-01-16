<?php include 'views/layouts/header.php'; ?>

<h2>Login</h2>

<div id="error-message" class="error"></div>

<form id="loginForm">
    <div class="form-group">
        <label for="email">Email or Username</label>
        <input type="text" id="email" name="email">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
    </div>

    <div class="form-group">
        <a href="/WT_RMS/forgot-password" class="fs-sm">Forgot Password?</a>
    </div>

    <button type="button" class="btn" onclick="submitLogin()">Login</button>
</form>

<?php include 'views/layouts/footer.php'; ?>
