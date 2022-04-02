<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

interface MapFieldInterface
{
    public function getId(): int;

    public function getType(): int;

    public function setType(int $type): void;

    public function getIsSystem(): bool;

    public function setIsSystem(bool $is_system): void;

    public function getEcost(): int;

    public function setEcost(int $ecost): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getColoniesClassesId(): int;

    public function setColoniesClassesId(int $colonies_classes_id): void;

    public function getDamage(): int;

    public function setDamage(int $damage): void;

    public function getXDamage(): int;

    public function setXDamage(int $x_damage): void;

    public function getXDamageSystem(): int;

    public function setXDamageSystem(int $x_damage_system): void;

    public function getView(): bool;

    public function setView(bool $view): void;

    public function getPassable(): bool;

    public function setPassable(bool $passable): void;
}