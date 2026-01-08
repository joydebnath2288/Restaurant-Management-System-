<?php
// controllers/PageController.php

class PageController extends Controller {
    
    public function home() {
        // Load featured menu items (random 3)
        $menu = $this->model('Menu');
        $stmt = $menu->getFeatured(3);
        $featured_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'featured_items' => $featured_items,
            'page_title' => 'Home'
        ];

        $this->view('pages/home', $data);
    }

    public function about() {
        $this->view('pages/about', ['page_title' => 'About Us']);
    }

    public function notFound() {
        http_response_code(404);
        $this->view('pages/404', ['page_title' => 'Page Not Found']);
    }
}
?>
