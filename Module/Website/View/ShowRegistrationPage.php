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
     * @route GET /register
     */
    public function __invoke(): void
    {
        $this->core->setTemplateTitle('Registration');
        $this->core->setTemplateFile('Index/showRegistrationPage.twig');
        $this->core->render();
    }

}
