<?php

declare(strict_types=1);

use Core\Module\Core\CoreControllerInterface;

$app = require_once __DIR__.'/../App/Bootstrap.php';
$dispatcher = require_once __DIR__.'/../App/Route.php';
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$core = $app->getContainer()->get(CoreControllerInterface::class);
// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
if ($app->getConfig('core.encrypt_url')) {
    if ($uri === '/') {
        $uri = encrypt('/', $app->getConfig('core.secret.key'), $app->getConfig('core.secret.random_iv'));
    }
    if (str_starts_with($uri, '/')) {
        $uri = substr($uri, 1);
    }

    $uri = decrypt($uri, $app->getConfig('core.secret.key'));
}

$app->setUri($uri);
$route = $dispatcher->dispatch($httpMethod, $uri);
switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $core->setTemplateTitle('404 - Page not found');
        $core->render('Index/show404Page');

        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 Method Not Allowed';

        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];
        $app->getContainer()->call($controller, $parameters);

        break;
}