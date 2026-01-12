<?php header("Content-type: application/javascript"); ?>

document.addEventListener("DOMContentLoaded", () => {
    if (!window.location.pathname.includes('login.html')) {
        checkAuth();
    }
});

function checkAuth() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../controler/api_auth.php', true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            try {
                const data = JSON.parse(xhr.responseText);
                if (!data.authenticated) {
                    window.location.href = 'login.html';
                } else {
                    injectNavbar(data.user);
                }
            } catch (e) {
                window.location.href = 'login.html';
            }
        } else {
            window.location.href = 'login.html';
        }
    };
    xhr.onerror = function() {
        window.location.href = 'login.html';
    };
    xhr.send();
}

function injectNavbar(user) {
    const navbarHTML = `
    <nav class="navbar">
        <a href="dashboard.html" class="brand">Smart Restaurant</a>
        <ul>
            <li><a href="dashboard.html">Dashboard</a></li>
            <li><a href="customerprofilemanagement.html">Profile</a></li>
            <li><a href="history.html">History</a></li>
            <li><a href="promotions.html">Promotions</a></li>
            <li><a href="employemanagement.html">Employees</a></li>
            <li><a href="#" onclick="logout()">Logout (${user.name})</a></li>
        </ul>
    </nav>
    `;

    document.body.insertAdjacentHTML('afterbegin', navbarHTML);
}

function logout() {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../controler/api_auth.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            try {
                const data = JSON.parse(xhr.responseText);
                window.location.href = data.redirect;
            } catch (e) {}
        }
    };
    xhr.send(JSON.stringify({ action: 'logout' }));
}
