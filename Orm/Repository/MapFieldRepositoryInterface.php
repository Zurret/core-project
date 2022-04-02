<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\MapFieldInterface;
use Doctrine\Persistence\ObjectRepository;

interface MapFieldRepositoryInterface extends ObjectRepository
{
    public function findByCoordinates(int $cx, int $cy): ?MapFieldInterface;
}
