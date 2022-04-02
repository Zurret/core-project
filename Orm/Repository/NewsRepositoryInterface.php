<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\NewsInterface;
use Doctrine\Persistence\ObjectRepository;

interface NewsRepositoryInterface extends ObjectRepository
{
    public function prototype(): NewsInterface;

    public function save(NewsInterface $news): void;

    public function delete(NewsInterface $news): void;

    public function getById(int $id): ?NewsInterface;

    public function getRecent(int $limit = 5): array;
}
