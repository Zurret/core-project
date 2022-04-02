<?php

declare(strict_types=1);

namespace Core\Module\Maindesk\View;

use Core\Module\Core\CoreControllerInterface;

class ShowMaindeskPage
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
        $this->core->setTemplateTitle('Startseite');
        $this->core->render('Maindesk/showMaindeskPage');
    }
}
