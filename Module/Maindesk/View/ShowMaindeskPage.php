<?php

declare(strict_types=1);

namespace Core\Module\Maindesk\View;

use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\MapRepositoryInterface;

class ShowMaindeskPage
{
    private CoreControllerInterface $core;

    private MapRepositoryInterface $map;

    public function __construct(
        CoreControllerInterface $core,
        MapRepositoryInterface $map
    ) {
        $this->core = $core;
        if (!$this->core->Auth()->isLoggedIn()) {
            $this->core->redirect('/login');
        }
        $this->map = $map;
    }

    /**
     * @route GET /
     */
    public function __invoke(): void
    {
        $this->core->setTemplateTitle('Startseite');

        $scan_range = 2;
        $x = 10;
        $y = 43;

        $this->core->setTemplateVar('map', $this->map->findByScanRange($x, $y, $scan_range));
        $this->core->setTemplateVar('scan_range', $scan_range);
        $this->core->setTemplateVar('cx', $x);
        $this->core->setTemplateVar('cy', $y);
        $this->core->setTemplateFile('Game/Maindesk.twig');
        $this->core->render();
    }
}
