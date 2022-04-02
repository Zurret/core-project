<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\MapInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

final class MapRepository extends EntityRepository implements MapRepositoryInterface
{
    /**
     * @throws NonUniqueResultException
     */
    public function findByCoordinates(int $cx, int $cy): ?MapInterface
    {
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.cx = :cx')
            ->andWhere('m.cy = :cy')
            ->setParameter('cx', $cx)
            ->setParameter('cy', $cy);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findByScanRange(int $cx, int $cy, int $range): array
    {
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.cx >= :cxMin')
            ->andWhere('m.cx <= :cxMax')
            ->andWhere('m.cy >= :cyMin')
            ->andWhere('m.cy <= :cyMax')
            ->setParameter('cxMin', $cx - $range)
            ->setParameter('cxMax', $cx + $range)
            ->setParameter('cyMin', $cy - $range)
            ->setParameter('cyMax', $cy + $range)
            ->orderBy('m.id', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
