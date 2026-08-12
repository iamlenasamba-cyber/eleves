<?php

$routes = [
    
    '/showMoyenne' => ['controller' => 'controller.php', 'action' => 'saveNote'],
    '/login' => ['controller' => 'authController.php', 'action' => 'login'],
    '/' => ['controller' => 'authController.php', 'action' => 'login'],
    
];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (isset($routes[$uri])) {
    $controller = $routes[$uri]['controller'];
    $action     = $routes[$uri]['action'];
    $file       = dirname(__DIR__) . '/controllers/' . $controller;

    if (file_exists($file)) {
        require_once $file;

        if (function_exists($action)) {
            $action();
        } else {
            http_response_code(500);
            echo "Action introuvable  " ;
        }
    } else {
        http_response_code(404);
        echo "Contrôleur introuvable ";
    }
} else {
    http_response_code(404);
    echo "Page introuvable";
}