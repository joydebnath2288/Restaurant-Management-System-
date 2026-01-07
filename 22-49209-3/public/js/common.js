// Common JS for Navigation and Auth

document.addEventListener("DOMContentLoaded", () => {
    // 1. Check Auth Status (unless on login page)
    if (!window.location.pathname.includes('login.html')) {
        checkAuth();
    }
});

function checkAuth() {
    fetch('../controler/api_auth.php')
        .then(res => res.json())
        .then(data => {
            if (!data.authenticated) {
                window.location.href = 'login.html';
            } else {
                injectNavbar(data.user);
            }
        })
        .catch(() => {
            window.location.href = 'login.html';
        });
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

    // Insert at beginning of body
    document.body.insertAdjacentHTML('afterbegin', navbarHTML);
}

function logout() {
    fetch('../controler/api_auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'logout' })
    })
        .then(res => res.json())
        .then(data => {
            window.location.href = data.redirect;
        });
}
