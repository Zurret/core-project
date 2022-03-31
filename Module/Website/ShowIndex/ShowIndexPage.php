<?php

declare(strict_types=1);

namespace Core\Module\Website\ShowIndex;

use Core\Module\Core\CoreControllerInterface;
use Core\Orm\Repository\PlayerRepositoryInterface;

class ShowIndexPage
{
    private CoreControllerInterface $_core;

    private PlayerRepositoryInterface $player;

    public function __construct(
        CoreControllerInterface $_core,
        PlayerRepositoryInterface $player
    ) {
        $this->_core = $_core;
        $this->player = $player;
    }

    /**
     * @route GET /
     */
    public function __invoke(): void
    {
        $this->_core->setTemplateTitle('Startseite');

        $this->_core->setTemplateVar('players', $this->player->findAll());
        $this->_core->setTemplateFile('Index/Home.twig');
        $this->_core->render();
    }
}
