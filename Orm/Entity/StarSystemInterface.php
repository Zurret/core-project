<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

interface StarSystemInterface
{
    public function getId(): int;

    public function getCx(): int;

    public function getCy(): int;

    public function getType(): int;

    public function getName(): string;

    public function getMaxX(): int;

    public function getMaxY(): int;
}