<?php

declare(strict_types=1);

namespace Core\Orm\Repository;

use Core\Orm\Entity\Player;
use Core\Orm\Entity\PlayerInterface;
use Doctrine\ORM\EntityRepository;

final class PlayerRepository extends EntityRepository implements PlayerRepositoryInterface
{
    public function prototype(): PlayerInterface
    {
        return new Player();
    }

    public function save(PlayerInterface $player): void
    {
        $em = $this->getEntityManager();

        $em->persist($player);
        $em->flush();
    }

    public function delete(PlayerInterface $player): void
    {
        $em = $this->getEntityManager();

        $em->remove($player);
        $em->flush();
    }

    public function getById(int $id): ?PlayerInterface
    {
        return $this->findOneBy([
            'id' => $id,
        ]);
    }
}
