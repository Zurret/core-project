<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\News;
use Core\Orm\Entity\NewsInterface;
use Doctrine\ORM\EntityRepository;

final class NewsRepository extends EntityRepository implements NewsRepositoryInterface
{
    public function prototype(): NewsInterface
    {
        return new News();
    }

    public function save(NewsInterface $news): void
    {
        $em = $this->getEntityManager();

        $em->persist($news);
        $em->flush();
    }

    public function delete(NewsInterface $news): void
    {
        $em = $this->getEntityManager();

        $em->remove($news);
        $em->flush();
    }

    public function getById(int $id): ?NewsInterface
    {
        return $this->findOneBy([
            'id' => $id,
        ]);
    }

    public function getRecent(int $limit = 5): array
    {
        return $this->findBy(
            [],
            ['created_at' => 'desc'],
            $limit
        );
    }
}
