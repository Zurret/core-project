<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

interface StarSystemMapInterface
{
    public function getId(): int;

    public function getSystem(): StarSystemInterface;

    public function getSx(): int;

    public function setSx(int $sx): StarSystemMapInterface;

    public function getSy(): int;

    public function setSy(int $sy): StarSystemMapInterface;

    public function getType(): int;

    public function setType(int $type): StarSystemMapInterface;
}
