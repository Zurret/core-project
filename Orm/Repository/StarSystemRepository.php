<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\StarSystemInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

final class StarSystemRepository extends EntityRepository implements StarSystemRepositoryInterface
{
    /**
     * @throws NonUniqueResultException
     */
    public function findByCoordinates(int $cx, int $cy): ?StarSystemInterface
    {
        $qb = $this->createQueryBuilder('s');
        $qb->where('s.cx = :cx')
            ->andWhere('s.cy = :cy')
            ->setParameter('cx', $cx)
            ->setParameter('cy', $cy);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
