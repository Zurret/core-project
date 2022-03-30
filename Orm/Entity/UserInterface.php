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
}
