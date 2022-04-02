<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\StarSystemInterface;
use Doctrine\Persistence\ObjectRepository;

interface StarSystemRepositoryInterface extends ObjectRepository
{
    public function findByCoordinates(int $cx, int $cy): ?StarSystemInterface;
}
