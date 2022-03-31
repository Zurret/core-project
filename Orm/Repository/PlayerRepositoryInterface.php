<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\PlayerInterface;
use Doctrine\Persistence\ObjectRepository;

interface PlayerRepositoryInterface extends ObjectRepository
{
    public function prototype(): PlayerInterface;

    public function save(PlayerInterface $player): void;

    public function delete(PlayerInterface $player): void;

    public function getById(int $id): ?PlayerInterface;
}
