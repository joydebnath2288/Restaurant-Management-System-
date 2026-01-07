<!DOCTYPE html>
<html>
<head>
    <title>AJAX JSON Test</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="centered-container" style="flex-direction:column;">
        <div class="box">
            <a href="index.php?controller=auth&action=login" class="nav-back">Back to Login</a>
            <h2>AJAX JSON Test</h2>
            <input type="text" id="ajaxInput" placeholder="Enter data">
            <button type="button" id="ajaxBtn">Send JSON (XMLHttpRequest)</button>
            <p id="ajaxResponse"></p>
        </div>
    </div>
    <script src="js/ajax.js"></script>
</body>
</html>
