<?php

class Router {

    public function route(): void {




         $routes = [
            '/showMoyenne' => ['file' => 'controller.php', 'class' => 'Controller', 'action' => 'saveNote'],
            '/login'=> ['file' => 'authController.php', 'class' => 'AuthController', 'action' => 'login'],
            '/'=> ['file' => 'authController.php','class' =>'AuthController','action' =>'login'],
        ];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($routes[$uri])) {
            $route = $routes[$uri];
            $file = dirname(__DIR__) . '/controllers/' . $route['file'];

            if (file_exists($file)) {
                require_once $file;

                $className = $route['class'];
                $action= $route['action'];

                if (class_exists($className)) {        
                    $controller = new $className();             
                    if (method_exists($controller, $action)) {
                         $controller->$action();
                    } else {
                        http_response_code(500);
                        
                        echo "Méthode introuvable dans la classe ";
                     }
                } else {
                        http_response_code(500);
                     echo "Classe  introuvable";
                }
            } else {
                http_response_code(404);
                  echo "Fichier Contrôleur introuvable";
            }
          } else {
            http_response_code(404);
            echo "Page introuvable";
         }
  
  
  
  
         }







}