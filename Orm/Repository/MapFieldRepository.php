<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\MapFieldInterface;
use Doctrine\ORM\EntityRepository;

final class MapFieldRepository extends EntityRepository implements MapFieldRepositoryInterface
{
    public function findByCoordinates(int $cx, int $cy): ?MapFieldInterface
    {
        return $this->findOneBy(['cx' => $cx, 'cy' => $cy]);
    }
}