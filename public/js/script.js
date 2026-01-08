// public/js/script.js

document.addEventListener('DOMContentLoaded', function() {
    console.log('Smart Restaurant System Loaded');

    // Example verification
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            // Basic client-side validation logic can go here
            // For now, let's just log submission
            console.log('Form submitted');
        });
    });
});
