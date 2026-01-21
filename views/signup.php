<?php
session_start();
if (!isset($_SESSION['role']) && isset($_COOKIE['user_role'])) {
    $_SESSION['role'] = $_COOKIE['user_role'];
}
if(isset($_SESSION['role'])){
    if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'){
        header("Location: dashboard.php");
    } else {
        header("Location: customer_dashboard.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="login-page">

<div class="centered-container" style="flex-direction: column;">
    <form id="signupForm" class="login-form">
        <h2>Sign Up</h2>
        <p id="errorMsg" class="error" style="display:none;"></p>

        <label>Username</label>
        <input type="text" id="username">
        <div id="err-username" class="input-error"></div>

        <label>Email</label>
        <input type="email" id="email">
        <div id="err-email" class="input-error"></div>

        <label>Password</label>
        <input type="password" id="password">
        <div id="err-password" class="input-error"></div>

        <label>Role</label>
        <select id="role">
            <option value="customer">Customer</option>
            <option value="admin">Admin</option>
        </select>
        <div id="err-role" class="input-error"></div>

        <button type="submit">Sign Up</button>
        <div style="text-align: center; margin-top: 10px;">
            <a href="login.php" style="text-decoration: none; color: #555;">Already have an account? Login</a>
        </div>
    </form>
</div>

<script>
document.getElementById('signupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    document.querySelectorAll('.input-error').forEach(el => el.innerText = "");

    let user = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let pass = document.getElementById('password').value;
    let role = document.getElementById('role').value;
    let valid = true;

    if(user.trim() === "") {
        document.getElementById('err-username').innerText = "Username is required";
        valid = false;
    }
    
    if(email.trim() === "") {
        document.getElementById('err-email').innerText = "Email is required";
        valid = false;
    } else if(!email.includes('@') || !email.includes('.')) { 
         document.getElementById('err-email').innerText = "Enter a valid email address";
         valid = false;
    }

    if(pass === "") {
        document.getElementById('err-password').innerText = "Password is required";
        valid = false;
    } else if(pass.length < 6) {
        document.getElementById('err-password').innerText = "Password must be at least 6 characters";
        valid = false;
    }

    if(!valid) return;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/Signup.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function() {
        if(this.status == 200) {
            try {
                let res = JSON.parse(this.responseText);
                if(res.status === "success") {
                    let form = document.getElementById("signupForm");
                    form.reset();
                    let msg = document.createElement("p");
                    msg.style.color = "green";
                    msg.style.fontWeight = "bold";
                    msg.innerText = "Signup successful! You can now login.";
                    form.insertBefore(msg, form.firstChild);
                } else {
                    if(res.field) {
                        document.getElementById('err-' + res.field).innerText = res.message;
                    } else {
                        document.getElementById('err-email').innerText = res.message; 
                    }
                }
            } catch(e) {
                console.error("Invalid response");
            }
        }
    };

    let data = {username: user, email: email, password: pass, role: role};
    xhr.send(JSON.stringify(data));
});
</script>

</body>
</html>
