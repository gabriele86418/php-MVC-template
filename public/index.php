<?php

    define('__ROOT__', '..');

    require_once __ROOT__ . '/resource/router.php';
    require_once __ROOT__ . '/src/controller/signup.php';
    require_once __ROOT__ . '/src/controller/base.php';

    $router = Router::getInstance();
    
    if ($router->getRoutesLen() === 0)
    {
        $router->addRoute(HTTP_GET, '/login', ['email', 'password'], function() {
            SignupController::renderPageSignup();
        });
    
        $router->addRoute(HTTP_POST, '/signup', [], function() {
            SignupController::processSignup();
        });
    
        $router->addRoute(HTTP_GET, '/about', [], function() {
            BaseController::renderPageAbout();
        });
    
        $router->addRoute(HTTP_GET, '/login/([a-zA-Z0-9]{10,100})', [], function($matches) {
            $token = $matches[1];
            $_GET['token'] = $token;
            include 'login.php';
        });
    
        $router->addRoute(HTTP_GET, '/login', ['token'], function($matches) {
            $token = $matches[1];
            $_GET['token'] = $token;
            include 'login.php';
        });
    
        $router->setNotFoundCallback(function() {
            BaseController::renderPageNotFound();
        });
    }

    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);   // page?x=value1&y=value2 ==> page

    $router->handleRequest($method, $path);

?>