<?php header("Content-type: application/javascript"); ?>

document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById('loginForm');
    const errorMsg = document.getElementById('errorMsg');

    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            errorMsg.style.display = 'none';

            const formData = new FormData(loginForm);
            const data = Object.fromEntries(formData.entries());

            const xhr = new XMLHttpRequest();
            const url = typeof API_URL !== 'undefined' ? API_URL : '../public/index.php?controller=auth&action=login';
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = function() {
                try {
                    const result = JSON.parse(xhr.responseText);
                    if (xhr.status >= 200 && xhr.status < 300) {
                        if (result.redirect) {
                            window.location.href = result.redirect;
                        }
                    } else {
                        throw new Error(result.error || 'Login failed');
                    }
                } catch (err) {
                    console.error(err);
                    errorMsg.textContent = "Error: " + err.message;
                    errorMsg.style.display = 'block';
                }
            };

            xhr.onerror = function() {
                const err = new Error('Network Error');
                console.error(err);
                errorMsg.textContent = "Error: " + err.message;
                errorMsg.style.display = 'block';
            };

            xhr.send(JSON.stringify(data));
        });
    }
});
