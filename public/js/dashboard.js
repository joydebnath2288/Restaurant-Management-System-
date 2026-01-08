// public/js/dashboard.js

document.addEventListener('DOMContentLoaded', function () {
    console.log("Dashboard Loaded");

    // Simple textual animation for stats
    const stats = document.querySelectorAll('.card p');
    stats.forEach(stat => {
        // Just a placeholder effect to show JS is running specific to dashboard
        stat.style.transition = 'color 0.5s';
        stat.addEventListener('mouseover', () => stat.style.color = '#007bff');
        stat.addEventListener('mouseout', () => stat.style.color = '#333');
    });
});
