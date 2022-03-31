<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

/**
 * @Entity(repositoryClass="Core\Orm\Repository\PlayerRepository")
 * @Table(
 *     name="core_player",
 *     indexes={
 *     }
 * )
 **/
class Player implements PlayerInterface
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** @Column(type="string", length=255, options={"default" : "Kolonist"}) */
    private $name = 'Kolonist';

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): PlayerInterface
    {
        $this->name = $name;

        return $this;
    }
}
