<?php

    $container = require_once __DIR__.'/../App/Bootstrap.php';
    $dispatcher = require_once __DIR__.'/../App/Route.php';

    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    // Strip query string (?foo=bar) and decode URI
    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    $route = $dispatcher->dispatch($httpMethod, $uri);

    switch ($route[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            echo '404 Not Found';
            break;

        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            echo '405 Method Not Allowed';
            break;

        case FastRoute\Dispatcher::FOUND:
            $controller = $route[1];
            $parameters = $route[2];
            $container->getContainer()->call($controller, $parameters);
            break;
    }
