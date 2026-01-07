// Auth JS for Login Page

document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById('loginForm');
    const errorMsg = document.getElementById('errorMsg');

    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            errorMsg.style.display = 'none';

            const formData = new FormData(loginForm);
            const data = Object.fromEntries(formData.entries());
            // data.action = 'login'; // No longer needed in body, handled by router

            fetch(typeof API_URL !== 'undefined' ? API_URL : '../public/index.php?controller=auth&action=login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(async res => {
                    const result = await res.json();
                    if (!res.ok) {
                        throw new Error(result.error || 'Login failed');
                    }
                    return result;
                })
                .then(result => {
                    if (result.redirect) {
                        window.location.href = result.redirect;
                    }
                })
                .catch((err) => {
                    console.error(err);
                    errorMsg.textContent = "Error: " + err.message;
                    errorMsg.style.display = 'block';
                });
        });
    }
});
