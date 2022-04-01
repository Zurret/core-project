<?php

declare(strict_types=1);

namespace Core\Module\Api;

use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\UserRepositoryInterface;

class ShowPopupTest
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
        exit('
        <title>Popup Test</title>
        <h1>Popup Test</h1>');
    }
}