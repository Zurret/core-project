<?php

declare(strict_types=1);

namespace Core\Module\Website\View;

use Core\Module\Core\CoreControllerInterface;

class ShowRegistrationPage
{
    private CoreControllerInterface $core;

    public function __construct(
        CoreControllerInterface $core,
    ) {
        $this->core = $core;
    }

    /**
     * @route GET /auth/register
     */
    public function __invoke(): void
    {
        $this->core->setTemplateTitle('Registration');
        $this->core->render('Index/showRegistrationPage');
    }
}
