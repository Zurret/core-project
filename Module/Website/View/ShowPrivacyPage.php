<?php

declare(strict_types=1);

namespace Core\Module\Website\View;

use Core\Module\Core\CoreControllerInterface;

class ShowPrivacyPage
{
    private CoreControllerInterface $core;

    public function __construct(
        CoreControllerInterface $core
    ) {
        $this->core = $core;
    }

    /**
     * @route GET /
     */
    public function __invoke(): void
    {
        $this->core->setTemplateTitle('Datenschutzerklärung');
        $this->core->setTemplateVar('abbreviation', $this->core->getConfig('core.name_short'));
        $this->core->render('Index/showPrivacyPage.twig');
    }
}
