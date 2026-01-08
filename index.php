<?php
// index.php

// 1. Settings
ini_set('display_errors', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
session_start();

// 2. Constants
// Dynamically calculate base URL
$path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$path = rtrim($path, '/');
define('BASE_URL', $path . '/');

// 3. Core & Helpers
require_once 'config/Csrf.php';
require_once 'config/Database.php';
require_once 'controllers/Controller.php';
require_once 'models/Model.php';
require_once 'config/Router.php';

// 4. CSRF Generation
$csrf_token = Csrf::generate();

// 5. Run App
$router = new Router();
?>

