<?php

declare(strict_types=1);

use FastRoute\RouteCollector;

/**
 * @readme https://github.com/nikic/FastRoute/blob/master/README.md
 */
$dispatcher = FastRoute\simpleDispatcher(static function (RouteCollector $r): void {
    /* Website */
    $r->addRoute('GET', '/', 'Core\Module\Website\View\ShowIndexPage');
    $r->addRoute('GET', '/cookies', 'Core\Module\Website\View\ShowCookiesPage');
    $r->addRoute('GET', '/privacy', 'Core\Module\Website\View\ShowPrivacyPage');
    $r->addRoute('GET', '/imprint', 'Core\Module\Website\View\ShowImprintPage');
    /* @ToDo */
        //$r->addRoute('GET', '/page/{pageId:\d+}', 'Core\Module\Website\View\ShowLoadPage');
    /* Authentication */
    $r->addGroup('/auth', function (RouteCollector $r) {
        $r->addRoute('GET', '/register', 'Core\Module\Website\View\ShowRegistrationPage');
        $r->addRoute('POST', '/register', ['Core\Module\Website\Action\Register', 'doRegistration']);
        $r->addRoute('GET', '/login', 'Core\Module\Website\View\ShowLoginPage');
        $r->addRoute('POST', '/login', ['Core\Module\Website\Action\Login', 'doLogin']);
        $r->addRoute('GET', '/logout/{token}', ['Core\Module\Website\Action\Logout', 'doLogout']);
    });
    /* Game */
    $r->addGroup('/game', function (RouteCollector $r) {
        $r->addRoute('GET', '/maindesk', 'Core\Module\Maindesk\View\ShowMaindeskPage');
        /* Tutorial */
        $r->addGroup('/tutorial', function (RouteCollector $r) {
            $r->addRoute('GET', '[/{tutorialId:\d+}[/{stepId:\d+}]]', 'Core\Module\Tutorial\View\ShowTutorialPage');
        });
    });
    /* API */
    $r->addGroup('/api', function (RouteCollector $r) {
        $r->addRoute('GET', '/popuptest', 'Core\Module\Api\ShowPopupTest');
    });
});

return $dispatcher;
