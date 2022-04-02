<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\User;
use Core\Orm\Entity\UserInterface;
use Doctrine\ORM\EntityRepository;

final class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function prototype(): UserInterface
    {
        return new User();
    }

    public function save(UserInterface $user): void
    {
        $em = $this->getEntityManager();

        $em->persist($user);
        $em->flush();
    }

    public function delete(UserInterface $user): void
    {
        $em = $this->getEntityManager();

        $em->remove($user);
        $em->flush();
    }

    public function getByEmail(string $email): ?UserInterface
    {
        return $this->findOneBy([
            'email' => $email,
        ]);
    }

    public function getByIdAndSession(int $id, string $session): ?UserInterface
    {
        return $this->findOneBy([
            'id'      => $id,
            'session' => $session,
        ]);
    }

    public function getByIdAndCookie(int $id, string $cookie): ?UserInterface
    {
        return $this->findOneBy([
            'id'      => $id,
            'cookie'  => $cookie,
        ]);
    }
}
