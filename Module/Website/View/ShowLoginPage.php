<?php

declare(strict_types=1);

namespace Core\Module\Website\View;

use Core\Module\Core\CoreControllerInterface;

class ShowLoginPage
{
    private CoreControllerInterface $core;

    public function __construct(
        CoreControllerInterface $core
    ) {
        $this->core = $core;
    }

    /**
     * __invoke.
     */
    public function __invoke(): void
    {
        $this->core->setTemplateTitle('Login');
        $this->core->render('Index/showLoginPage');
    }
}
