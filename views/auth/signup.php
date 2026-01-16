<?php include 'views/layouts/header.php'; ?>

<h2>Sign Up</h2>

<div id="error-message" class="error"></div>

<form id="signupForm">
    <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
    </div>

    <div class="form-group">
        <label for="role">Role</label>
        <select id="role" name="role" style="width: 100%; padding: 10px;">
            <option value="customer">Customer</option>
            <option value="staff">Staff</option>
        </select>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
    </div>

    <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password">
    </div>

    <button type="button" class="btn" onclick="submitSignup()">Sign Up</button>
</form>

<?php include 'views/layouts/footer.php'; ?>
