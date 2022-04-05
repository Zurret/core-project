<?php

declare(strict_types=1);

namespace Core\Module\Website\Action;

use Core\Module\Core\CoreControllerInterface;

class Logout
{
    private CoreControllerInterface $core;

    public function __construct(
        CoreControllerInterface $core
    ) {
        $this->core = $core;
    }

    /**
     * doLogout.
     *
     * @param mixed $token
     */
    public function doLogout(string $token): void
    {
        if ($this->core->getToken() === $token) {
            $this->core->setNotification('Logout erfolgreich.');
            $this->core->Auth()->logout();
        } else {
            $this->core->setNotification('Logout fehlgeschlagen.');
            $this->core->redirect('/');
        }
    }
}
