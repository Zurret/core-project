<?php

declare(strict_types=1);

use FastRoute\RouteCollector;

/**
 * @readme https://github.com/nikic/FastRoute/blob/master/README.md
 */
$dispatcher = FastRoute\simpleDispatcher(static function (RouteCollector $r): void {
    $r->addRoute('GET', '/', 'Core\Module\Website\View\ShowIndexPage');
    $r->addRoute('GET', '/register', 'Core\Module\Website\View\ShowRegistrationPage');
    $r->addRoute('POST', '/register', ['Core\Module\Website\Action\Register', 'doRegistration']);
    $r->addRoute('GET', '/login', 'Core\Module\Website\View\ShowLoginPage');
    $r->addRoute('POST', '/login', ['Core\Module\Website\Action\Login', 'doLogin']);
    $r->addRoute('GET', '/logout/{token}', ['Core\Module\Website\Action\Logout', 'doLogout']);
    $r->addGroup('/game', function (RouteCollector $r) {
        $r->addRoute('GET', '/maindesk', 'Core\Module\Maindesk\View\ShowMaindeskPage');
    });
    $r->addGroup('/api', function (RouteCollector $r) {
        $r->addRoute('GET', '/popuptest', 'Core\Module\Api\ShowPopupTest');
    });
});

return $dispatcher;
