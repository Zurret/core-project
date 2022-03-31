<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

interface PlayerInterface
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): PlayerInterface;
}
