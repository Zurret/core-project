<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\AccountInterface;
use Doctrine\Persistence\ObjectRepository;

interface AccountRepositoryInterface extends ObjectRepository
{
    public function prototype(): AccountInterface;

    public function save(AccountInterface $account): void;

    public function delete(AccountInterface $account): void;

    public function getByEmail(string $email): ?AccountInterface;

    public function getByIdAndSession(int $id, string $session): ?AccountInterface;

    public function getByIdAndCookie(int $id, string $cookie): ?AccountInterface;
}
