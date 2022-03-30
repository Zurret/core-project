<?php

declare(strict_types=1);

use FastRoute\RouteCollector;
use Core\Lib\Auth;

/**
 * @readme https://github.com/nikic/FastRoute/blob/master/README.md
 */
$dispatcher = FastRoute\simpleDispatcher(static function (RouteCollector $r): void {
    $r->addRoute('GET', '/', 'Core\Module\Website\ShowIndex\ShowIndexPage');
    $r->addRoute('GET', '/register', 'Core\Module\Website\ShowRegistration\ShowRegistrationPage');
    $r->addRoute('POST', '/register', ['Core\Module\Website\ShowRegistration\ShowRegistrationPage', 'doRegistration']);
    $r->addRoute('GET', '/login', 'Core\Module\Website\ShowLogin\ShowLoginPage');
    $r->addRoute('POST', '/login', ['Core\Module\Website\ShowLogin\ShowLoginPage', 'doLogin']);
    $r->addGroup('/game', function (RouteCollector $r) {
        $r->addRoute('GET', '/maindesk', 'Core\Module\Website\ShowIndex\ShowIndexPage');
    });
});

return $dispatcher;
