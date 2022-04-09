<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

interface AccountInterface
{
    public function getId(): int;

    public function getEMail(): string;

    public function setEMail(string $email): AccountInterface;

    public function getPassword(): string;

    public function setPassword(string $password): AccountInterface;

    public function getSessionString(): ?string;

    public function setSessionString(?string $session): AccountInterface;

    public function getCookieString(): ?string;

    public function setCookieString(?string $cookie): AccountInterface;

    public function getPlayer(): PlayerInterface;

    public function setPlayer(PlayerInterface $player): AccountInterface;

    public function getAccessLevel(): int;

    public function setAccessLevel(int $access_level): AccountInterface;

    public function getLastLogin(): int;

    public function setLastLogin(int $last_login): AccountInterface;
}
