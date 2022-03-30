<?php

declare(strict_types=1);

namespace Core\Module\Website\ShowIndex;

use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\UserRepositoryInterface;

class ShowIndexPage
{
    private CoreControllerInterface $_core;

    private UserRepositoryInterface $user;

    public function __construct(
        CoreControllerInterface $_core,
        UserRepositoryInterface $user
    ) {
        $this->_core = $_core;
        $this->user = $user;
    }

    /**
     * @route GET /
     */
    public function __invoke(): void
    {
        $this->_core->setTemplateTitle('Startseite');

        $this->_core->setTemplateVar('users', $this->user->findAll());
        $this->_core->setTemplateFile('Index/Home.twig');
        $this->_core->render();
    }
}
