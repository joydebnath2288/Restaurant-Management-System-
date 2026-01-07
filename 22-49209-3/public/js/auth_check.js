/**
 * auth_check.js
 * Checks if the 'is_logged_in' cookie is present.
 * If not, redirects to the login page.
 * This prevents users from viewing protected pages via the Back button after logout.
 */

(function () {
    function getCookie(name) {
        let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
        return null; // Return null if not found
    }

    if (!getCookie('is_logged_in')) {
        // Cookie missing, force redirect to login
        window.location.href = 'index.php?controller=auth';
    }
})();
