<?php

$app = require_once __DIR__.'/../App/Bootstrap.php';
$dispatcher = require_once __DIR__.'/../App/Route.php';

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$core = $app->getContainer()->get(\Core\Module\Core\CoreControllerInterface::class);

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

if ($app->getConfig('core.encrypt_url')) {
    if ($uri === '/') {
        $uri = \Core\Lib\Helper::encrypt('/', $app->getConfig('core.secret'));
    }
    if (strpos($uri, '/') === 0) {
        $uri = substr($uri, 1);
    }

    $uri = \Core\Lib\Helper::decrypt($uri, $app->getConfig('core.secret'));
}

$route = $dispatcher->dispatch($httpMethod, $uri);

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $core->setTemplateTitle('404 - Page not found');
        $core->setTemplateFile('Index/show404Page.twig');
        $core->render();
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        exit('405 Method Not Allowed');
        break;

    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];
        $app->getContainer()->call($controller, $parameters);
        break;
}
