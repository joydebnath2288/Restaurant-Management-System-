<?php
// core/Router.php

class Router {
    protected $controller = 'PageController';
    protected $method = 'home';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // 1. Controller Logic
        if (isset($url['controller'])) {
            // Sanitize
            $c_name = preg_replace('/[^a-zA-Z0-9]/', '', $url['controller']);
            $controllerName = ucfirst($c_name) . 'Controller';
            
            if (file_exists('controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
            } else {
                // Controller not found
                $this->handle404(); 
                return;
            }
        }

        require_once 'controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Method Logic
        if (isset($url['action'])) {
             // Sanitize
            $actionName = preg_replace('/[^a-zA-Z0-9_]/', '', $url['action']);
            
            if (method_exists($this->controller, $actionName)) {
                $this->method = $actionName;
            } else {
                // Method not found
                $this->handle404();
                return;
            }
        } else {
            // Default method if none specified
            // If it's PageController, keep default 'home'.
            // If it's any other controller (Menu, Order), default to 'index'.
            if (!$this->controller instanceof PageController) {
                if(method_exists($this->controller, 'index')) {
                    $this->method = 'index';
                }
            }
        }

        // 3. Execute
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        return $_GET;
    }

    private function handle404() {
        // Fallback to PageController::notFound()
        require_once 'controllers/PageController.php';
        $page = new PageController();
        $page->notFound();
        exit;
    }
}
