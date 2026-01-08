<?php
// core/Controller.php

class Controller {
    
    // Load Model
    public function model($model) {
        require_once 'models/' . $model . '.php';
        // Assume models expect DB connection or handle it internally
        // In this modern refactor, Base Model will handle DB
        return new $model();
    }

    // Load View
    public function view($view, $data = []) {
        // Extract data to variables
        extract($data);
        
        // Check if view file exists
        if(file_exists('views/' . $view . '.php')) {
            require_once 'views/' . $view . '.php';
        } else {
            die("View does not exist: " . $view);
        }
    }
    
    // Redirect Helper
    public function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit;
    }
}
