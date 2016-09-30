<?php


use Application\Core\Router;

require_once 'application/autoloader.php';

$router = Router::getInstance();
$router->get("/", "MainController@index");
$router->dispatch();