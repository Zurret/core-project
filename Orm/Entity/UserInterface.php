<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

interface UserInterface
{
    public function getId(): int;

    public function getEMail(): string;

    public function setEMail(string $email): UserInterface;

    public function getPassword(): string;

    public function setPassword(string $password): UserInterface;

    public function getSession(): string;

    public function setSession(string $session): UserInterface;

    public function getPlayer(): PlayerInterface;

    public function setPlayer(PlayerInterface $player): UserInterface;

    public function getAccessLevel(): int;

    public function setAccessLevel(int $access_level): UserInterface;

    public function getLastLogin(): int;

    public function setLastLogin(int $last_login): UserInterface;
}
