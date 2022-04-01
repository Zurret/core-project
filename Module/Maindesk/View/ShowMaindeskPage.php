<?php

declare(strict_types=1);

namespace Core\Module\Maindesk\View;

use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\UserRepositoryInterface;

class ShowMaindeskPage
{
    private CoreControllerInterface $core;

    private UserRepositoryInterface $user;

    public function __construct(
        CoreControllerInterface $core,
        UserRepositoryInterface $user
    ) {
        $this->core = $core;
        $this->user = $user;
        if (!$this->core->Auth()->isLoggedIn()) {
            $this->core->redirect('/login');
        }
    }

    /**
     * @route GET /
     */
    public function __invoke(): void
    {
        $this->core->setTemplateTitle('Startseite');

        $this->core->setTemplateVar('users', $this->user->findAll());
        $this->core->setTemplateFile('Game/Maindesk.twig');
        $this->core->render();
    }
}
