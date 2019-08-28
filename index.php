<?php

define('UPLOAD_DIR', __DIR__.'/uploads/');

session_start();

if (! isset($_SESSION['auth']) && $_SERVER['REQUEST_URI'] !== '/login') {
    header('Location: /login');
    return;
}

require 'vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function($r) {
    $r->addRoute('GET', '/', function(){
        $controller = new App\Controller\Main();
        $controller->run();
    });

    $r->addRoute(['GET', 'POST'], '/login', function(){
        $controller = new App\Controller\Login();
        $controller->run();
    });

    $r->addRoute(['GET', 'POST'], '/users', function(){
        $controller = new App\Controller\Users();
        $controller->run();
    });

    $r->addRoute(['GET', 'POST'], '/users/create', function(){
        $controller = new App\Controller\Users();
        $controller->runCreate();
    });

    $r->addRoute(['GET', 'POST'], '/users/update', function(){
        $controller = new App\Controller\Users();
        $controller->runUpdate();
    });

    $r->addRoute(['GET', 'POST'], '/users/delete', function(){
        $controller = new App\Controller\Users();
        $controller->runDelete();
    });

    $r->addRoute(['GET', 'POST'], '/accounts', function(){
        $controller = new App\Controller\Accounts();
        $controller->run();
    });

    $r->addRoute(['GET', 'POST'], '/accounts/create', function(){
        $controller = new App\Controller\Accounts();
        $controller->runCreate();
    });

    $r->addRoute(['GET', 'POST'], '/accounts/update', function(){
        $controller = new App\Controller\Accounts();
        $controller->runUpdate();
    });

    $r->addRoute(['GET', 'POST'], '/accounts/delete', function(){
        $controller = new App\Controller\Accounts();
        $controller->runDelete();
    });
    $r->addRoute(['GET', 'POST'], '/tasks', function(){
        $controller = new App\Controller\Tasks();
        $controller->run();
    });

    $r->addRoute(['GET', 'POST'], '/tasks/create', function(){
        $controller = new App\Controller\Tasks();
        $controller->runCreate();
    });

    $r->addRoute(['GET', 'POST'], '/tasks/update', function(){
        $controller = new App\Controller\Tasks();
        $controller->runUpdate();
    });

    $r->addRoute(['GET', 'POST'], '/tasks/delete', function(){
        $controller = new App\Controller\Tasks();
        $controller->runDelete();
    });
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo 'Роут не найден!';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo 'Роут есть, а метода нет!';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        $handler($vars);
        break;
}
