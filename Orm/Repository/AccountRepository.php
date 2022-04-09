<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\Account;
use Core\Orm\Entity\AccountInterface;
use Doctrine\ORM\EntityRepository;

final class AccountRepository extends EntityRepository implements AccountRepositoryInterface
{
    public function prototype(): AccountInterface
    {
        return new Account();
    }

    public function save(AccountInterface $account): void
    {
        $em = $this->getEntityManager();

        $em->persist($account);
        $em->flush();
    }

    public function delete(AccountInterface $account): void
    {
        $em = $this->getEntityManager();

        $em->remove($account);
        $em->flush();
    }

    public function getByEmail(string $email): ?AccountInterface
    {
        return $this->findOneBy([
            'email' => $email,
        ]);
    }

    public function getByIdAndSession(int $id, string $session): ?AccountInterface
    {
        return $this->findOneBy([
            'id'      => $id,
            'session' => $session,
        ]);
    }

    public function getByIdAndCookie(int $id, string $cookie): ?AccountInterface
    {
        return $this->findOneBy([
            'id'     => $id,
            'cookie' => $cookie,
        ]);
    }
}
