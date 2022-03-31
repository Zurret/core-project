<?php

declare(strict_types=1);

namespace Core\Module\Maindesk;

use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\UserRepositoryInterface;

class ShowMaindeskPage
{
    private CoreControllerInterface $_core;

    private UserRepositoryInterface $user;

    public function __construct(
        CoreControllerInterface $_core,
        UserRepositoryInterface $user
    ) {
        $this->_core = $_core;
        $this->_core->onlyForPlayers();
        $this->user = $user;
    }

    /**
     * @route GET /
     */
    public function __invoke(): void
    {
        $this->_core->setTemplateTitle('Startseite');

        $this->_core->setTemplateVar('users', $this->user->findAll());
        $this->_core->setTemplateFile('Game/Maindesk.twig');
        $this->_core->render();
    }
}
