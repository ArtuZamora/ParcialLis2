<?php
session_start();
include_once 'Core/Config.php';
include_once 'Core/Routing.php';
$router = new Routing();
include_once 'Controller/' . $router->controller . '.php';
$controller = new $router->controller();
$method =  $router->method;
$controller->$method($router->param);
