<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

interface PlayerInterface
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): PlayerInterface;

    public function getLevel(): int;

    public function setLevel(int $level): PlayerInterface;

    public function getExternalReputation(): int;

    public function setExternalReputation(int $external_reputation): PlayerInterface;

    public function addExternalReputation(int $external_reputation): PlayerInterface;

    public function getInternalReputation(): int;

    public function setInternalReputation(int $internal_reputation): PlayerInterface;

    public function addInternalReputation(int $internal_reputation): PlayerInterface;

    public function getReputation(): int;

    public function isNpc(): bool;

    public function setNpc(bool $npc): PlayerInterface;

    public function isNewbie(): bool;
}
