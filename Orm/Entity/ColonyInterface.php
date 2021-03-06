<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

interface ColonyInterface
{
    public function getId(): int;

    public function getPlayerId(): int;

    public function getPlayer(): PlayerInterface;

    public function setAccount(PlayerInterface $player): ColonyInterface;

    public function getTypeId(): int;

    public function getStarsystemMapId(): int;

    public function getColonyMapId(): int;

    public function getXSize(): int;

    public function setXSize(int $x_size): Colony;

    public function getYSize(): int;

    public function setYSize(int $y_size): Colony;

    public function getLevel(): int;
}
