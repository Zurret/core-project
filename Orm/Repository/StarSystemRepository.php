<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\StarSystem;
use Core\Orm\Entity\StarSystemInterface;
use Doctrine\ORM\EntityRepository;

final class StarSystemRepository extends EntityRepository implements StarSystemRepositoryInterface
{
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
