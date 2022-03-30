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
    $r->addGroup('/game', function (RouteCollector $r) {
        $r->addRoute('GET', '/maindesk', 'Core\Module\Website\ShowIndex\ShowIndexPage');
    });
});

return $dispatcher;
