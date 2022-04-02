<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Doctrine\Persistence\ObjectRepository;
use Core\Orm\Entity\MapInterface;

interface MapRepositoryInterface extends ObjectRepository
{
    public function findByCoordinates(int $cx, int $cy): ?MapInterface;

    public function findByScanRange(int $cx, int $cy, int $range): array;
}