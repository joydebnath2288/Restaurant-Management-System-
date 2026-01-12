<?php header("Content-type: application/javascript"); ?>

(function () {
    function getCookie(name) {
        let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
        return null; 

    }

    if (!getCookie('is_logged_in')) {
        

        window.location.href = 'index.php?controller=auth';
    }
})();
