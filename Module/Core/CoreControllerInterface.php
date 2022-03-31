<?php

declare(strict_types=1);

namespace Core\Module\Core;

use Core\Orm\Entity\UserInterface;

interface CoreControllerInterface
{
    public function render(): void;

    public function getUser(): ?UserInterface;

    public function onlyForPlayers(): void;

    public function onlyForNpc(): void;

    public function onlyForAdmin(): void;

    public function getCoreName(): string;

    public function getConfig(string $var): mixed;

    public function setNotification(mixed $notification): void;

    public function getNotification(): ?array;

    public function setToken(): void;

    public function getToken(): string;

    public function checkToken(): bool;

    public function getTokenInput(): string;

    public function setTemplateFile(string $tpl): void;

    public function setTemplateVar(string $key, mixed $variable): void;

    public function setTemplateTitle(string $variable): void;
}
