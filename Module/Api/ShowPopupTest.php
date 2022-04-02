<?php

declare(strict_types=1);

namespace Core\Module\Api;

use Core\Module\Core\CoreControllerInterface;

class ShowPopupTest
{
    private CoreControllerInterface $core;

    public function __construct(
        CoreControllerInterface $core
    ) {
        $this->core = $core;
        if (!$this->core->Auth()->isLoggedIn()) {
            $this->core->redirect('/auth/login');
        }
    }

    /**
     * @route GET /
     */
    public function __invoke(): void
    {
        exit('<title>Popup Test</title><h1>Popup Test</h1>');
    }

}
