<?php

declare(strict_types=1);

use FastRoute\RouteCollector;

/**
 * @readme https://github.com/nikic/FastRoute/blob/master/README.md
 */
$dispatcher = FastRoute\simpleDispatcher(static function (RouteCollector $r): void {
    $r->addRoute('GET', '/', 'Core\Module\Website\ShowIndex\ShowIndexPage');
    $r->addRoute('GET', '/register', 'Core\Module\Website\ShowRegistration\ShowRegistrationPage');
    $r->addRoute('POST', '/register', ['Core\Module\Website\ShowRegistration\ShowRegistrationPage', 'doRegistration']);
    $r->addRoute('GET', '/login', 'Core\Module\Website\ShowLogin\ShowLoginPage');
    $r->addRoute('POST', '/login', ['Core\Module\Website\ShowLogin\ShowLoginPage', 'doLogin']);
    $r->addRoute('GET', '/logout/{token}', ['Core\Module\Website\ShowLogin\ShowLoginPage', 'doLogout']);
    $r->addGroup('/game', function (RouteCollector $r) {
        $r->addRoute('GET', '/maindesk', 'Core\Module\Maindesk\ShowMaindeskPage');
    });
    $r->addGroup('/api', function (RouteCollector $r) {
        $r->addRoute('GET', '/popuptest', 'Core\Module\Api\ShowPopupTest');
    });
});

return $dispatcher;
