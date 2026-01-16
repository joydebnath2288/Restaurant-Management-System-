function validateSignupForm() {
    var fullName = document.getElementById("full_name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    var errorDiv = document.getElementById("error-message");

    errorDiv.innerHTML = "";

    if (fullName == "" || email == "" || password == "" || confirmPassword == "") {
        errorDiv.innerHTML = "All fields are required.";
        return false;
    }

    if (password.length < 8) {
        errorDiv.innerHTML = "Password must be at least 8 characters.";
        return false;
    }

    if (password != confirmPassword) {
        errorDiv.innerHTML = "Passwords do not match.";
        return false;
    }

    return true;
}

function submitSignup() {
    if (!validateSignupForm()) {
        return;
    }

    var formData = new FormData(document.getElementById("signupForm"));

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "signup", true);

    xhr.onload = function () {
        if (xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status == "success") {
                window.location.href = "login";
            } else {
                document.getElementById("error-message").innerHTML = response.message;
            }
        } else {
            document.getElementById("error-message").innerHTML = "Error " + xhr.status + ": " + xhr.statusText;
        }
    };

    xhr.send(formData);
}

function validateLoginForm() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var errorDiv = document.getElementById("error-message");

    errorDiv.innerHTML = "";

    if (email == "" || password == "") {
        errorDiv.innerHTML = "All fields are required.";
        return false;
    }

    return true;
}

function submitLogin() {
    if (!validateLoginForm()) {
        return;
    }

    var formData = new FormData(document.getElementById("loginForm"));

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "login", true);

    xhr.onload = function () {
        if (xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status == "success") {
                window.location.href = "dashboard";
            } else {
                document.getElementById("error-message").innerHTML = response.message;
            }
        } else {
            document.getElementById("error-message").innerHTML = "Error " + xhr.status + ": " + xhr.statusText;
        }
    };

    xhr.send(formData);
}
