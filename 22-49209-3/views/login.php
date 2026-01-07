<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Restaurant</title>
    <!-- Asset paths are relative to public/index.php -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Smart Restaurant System</h2>
            <div id="errorMsg" class="error-msg"></div>
            <form id="loginForm">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required placeholder="Enter Login ID">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter Password">
                </div>
                <button type="submit" class="btn" style="width:100%">Login</button>
            </form>
        </div>
    </div>
    <!-- Pass the API URL to JS -->
    <script>
        const API_URL = 'index.php?controller=auth&action=login';
    </script>
    <script src="js/auth.js"></script>
</body>
</html>
