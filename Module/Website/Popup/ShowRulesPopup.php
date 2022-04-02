<?php

declare(strict_types=1);

namespace Core\Module\Website\Popup;

use Core\Module\Core\CoreControllerInterface;

class ShowRulesPopup
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
        $this->core->setTemplateTitle('Regeln');
        $this->core->render('_Popup/showRulesPopup');
    }

}
