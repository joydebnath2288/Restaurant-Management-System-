<?php
session_start();

$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerName = ucfirst($controller);
$controllerFile = "../controllers/" . $controllerName . ".php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $fullControllerName = "Controllers\\" . $controllerName;
    $controllerObject = new $fullControllerName();

    if (method_exists($controllerObject, $action)) {
        $controllerObject->$action();
    } else {
        echo "Action not found";
    }
} else {
    echo "Controller not found";
}
