// public/js/menu.js

document.addEventListener('DOMContentLoaded', function () {

    // 1. AJAX Add to Cart
    const addForms = document.querySelectorAll('.menu-item form');
    addForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Stop reload

            const formData = new FormData(this);
            // Append a flag to tell controller this is AJAX
            formData.append('ajax', '1');
            // Append CSRF Token (defined in footer)
            formData.append('csrf_token', CSRF_TOKEN);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Show fancy notification instead of alert
                        showToast("Item added to cart! Total items: " + data.cart_count);
                        // Update cart count in header if it existed (TODO)
                    } else {
                        showToast("Error adding item.", true);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    // Fallback (maybe user not logged in, redirect)
                    window.location.href = this.action;
                });
        });
    });

    // 2. Real-time Search
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Search menu items...';
    searchInput.style.width = '100%';
    searchInput.style.padding = '10px';
    searchInput.style.marginBottom = '20px';
    searchInput.style.border = '2px solid #007bff';
    searchInput.style.borderRadius = '5px';

    const menuGrid = document.querySelector('.menu-grid');
    if (menuGrid) {
        menuGrid.parentNode.insertBefore(searchInput, menuGrid);

        searchInput.addEventListener('input', function (e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.menu-item');

            items.forEach(item => {
                const name = item.querySelector('h3').innerText.toLowerCase();
                const desc = item.querySelector('p').innerText.toLowerCase();

                if (name.includes(term) || desc.includes(term)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    function showToast(message, isError = false) {
        const toast = document.createElement('div');
        toast.innerText = message;
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.background = isError ? '#dc3545' : '#28a745';
        toast.style.color = '#fff';
        toast.style.padding = '15px 25px';
        toast.style.borderRadius = '5px';
        toast.style.boxShadow = '0 2px 10px rgba(0,0,0,0.2)';
        toast.style.zIndex = '1000';
        toast.style.animation = 'fadeIn 0.5s';

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
});
