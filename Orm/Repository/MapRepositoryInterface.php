<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\MapInterface;
use Doctrine\Persistence\ObjectRepository;

interface MapRepositoryInterface extends ObjectRepository
{
    public function findByCoordinates(int $cx, int $cy): ?MapInterface;

    public function findByScanRange(int $cx, int $cy, int $range): array;
}
