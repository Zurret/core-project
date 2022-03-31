<?php

declare(strict_types=1);

namespace Core\Module\Website\ShowIndex;

use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\PlayerRepositoryInterface;

class ShowIndexPage
{
    private CoreControllerInterface $core;

    private PlayerRepositoryInterface $player;

    public function __construct(
        CoreControllerInterface $core,
        PlayerRepositoryInterface $player
    ) {
        $this->core = $core;
        $this->player = $player;
    }

    /**
     * @route GET /
     */
    public function __invoke(): void
    {
        $this->core->setTemplateTitle('Startseite');

        $this->core->setTemplateVar('players', $this->player->findAll());
        $this->core->setTemplateFile('Index/Home.twig');
        $this->core->render();
    }
}
