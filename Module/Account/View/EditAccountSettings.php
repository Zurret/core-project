<?php

declare(strict_types=1);

namespace Core\Module\Account\View;

use Core\Module\Core\CoreControllerInterface;

class EditAccountSettings
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
        $this->core->setTemplateTitle('Account Einstellungen');
        $this->core->setTemplateVar('account', $this->core->Auth()->getUser());
        $this->core->setTemplateVar('player', $this->core->Auth()->getUser()->getPlayer());
        $this->core->render('Account/showSettingsPage');
    }
}
