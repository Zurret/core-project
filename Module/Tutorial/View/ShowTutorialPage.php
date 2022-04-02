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
            $this->core->redirect('/login');
        }
    }

    public function __invoke(?int $tutorialId = null, ?int $stepId = null): void
    {
        $this->core->setTemplateTitle('Startseite');
        $this->core->setTemplateFile('Tutorial/showTutorialPage.twig');
        $this->core->setTemplateVar('tutorialId', $tutorialId);
        $this->core->setTemplateVar('stepId', $stepId);
        $this->core->render();
    }
}
