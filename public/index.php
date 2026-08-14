<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}  
require_once dirname(__DIR__) . "/app/core/router.php";

  $router = new Router();
$router->route();