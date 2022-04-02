<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

interface MapInterface
{
    public function getId(): int;

    public function getCx(): int;

    public function setCx(int $cx): void;

    public function getCy(): int;

    public function setCy(int $cy): void;

    public function getStarSystem(): ?StarSystem;

    public function setStarSystem(?StarSystem $starSystem): void;

    public function getMapField(): ?MapField;

    public function setMapField(?MapField $mapField): void;
}
