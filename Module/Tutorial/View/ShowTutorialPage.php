<?php

declare(strict_types=1);

namespace Core\Module\Tutorial\View;

use Core\Module\Core\CoreControllerInterface;

class ShowTutorialPage
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

    public function __invoke(int $tutorialId = 1, int $stepId = 1): void
    {
        $tutorialId = max(1, $tutorialId);
        $stepId = max(1, $stepId);

        $this->core->setTemplateTitle('Tutorial');
        $this->core->setTemplateVar('tutorialId', $tutorialId);
        $this->core->setTemplateVar('stepId', $stepId);
        $this->core->render('Tutorial/showTutorialPage');
    }
}
