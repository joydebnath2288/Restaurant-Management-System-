// public/js/auth.js

document.addEventListener('DOMContentLoaded', function () {

    // Login Form Validation
    const loginForm = document.querySelector('form[action*="login"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            const email = this.querySelector('input[name="email"]').value;
            const password = this.querySelector('input[name="password"]').value;

            if (!validateEmail(email)) {
                e.preventDefault();
                alert("Please enter a valid email address.");
            }
        });
    }

    // Signup Form Validation (Strength Meter)
    const signupForm = document.querySelector('form[action*="signup"]');
    if (signupForm) {
        const passwordInput = signupForm.querySelector('input[name="password"]');

        // Create strength meter UI
        if (passwordInput) {
            const meter = document.createElement('div');
            meter.id = 'password-strength';
            meter.style.height = '5px';
            meter.style.marginTop = '5px';
            meter.style.transition = 'width 0.3s';
            passwordInput.parentNode.insertBefore(meter, passwordInput.nextSibling);

            passwordInput.addEventListener('input', function () {
                const strength = calculateStrength(this.value);
                updateMeter(meter, strength);
            });
        }

        signupForm.addEventListener('submit', function (e) {
            const password = this.querySelector('input[name="password"]').value;
            if (password.length < 6) {
                e.preventDefault();
                alert("Password must be at least 6 characters long.");
            }
        });
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function calculateStrength(password) {
        let strength = 0;
        if (password.length > 5) strength += 1;
        if (password.length > 8) strength += 1;
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        return strength;
    }

    function updateMeter(meter, strength) {
        switch (strength) {
            case 0: meter.style.width = '0%'; meter.style.background = 'transparent'; break;
            case 1: meter.style.width = '25%'; meter.style.background = 'red'; break;
            case 2: meter.style.width = '50%'; meter.style.background = 'orange'; break;
            case 3: meter.style.width = '75%'; meter.style.background = 'yellow'; break;
            case 4: meter.style.width = '100%'; meter.style.background = 'green'; break;
        }
    }
});
