<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\UserInterface;
use Doctrine\Persistence\ObjectRepository;

interface UserRepositoryInterface extends ObjectRepository
{
    public function prototype(): UserInterface;
}
