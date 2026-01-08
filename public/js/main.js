// public/js/main.js

document.addEventListener('DOMContentLoaded', function () {
    console.log("Smart Restaurant System Loaded.");

    // Auto-hide alerts after 3 seconds
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);
    }
});
