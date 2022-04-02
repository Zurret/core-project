<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Doctrine\Persistence\ObjectRepository;
use Core\Orm\Entity\MapFieldInterface;

interface MapFieldRepositoryInterface extends ObjectRepository
{
    public function findByCoordinates(int $cx, int $cy): ?MapFieldInterface;
}