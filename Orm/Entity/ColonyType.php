<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

/**
 * @Entity(repositoryClass="Core\Orm\Repository\ColonyRepository")
 * @Table(
 *     name="core_colony_type",
 * )
 **/
class ColonyType implements ColonyTypeInterface
{

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @Column(type="string", length=255)
     */
    private string $name;

    /**
     * @Column(type="string", length=255)
     */
    private string $description;


    public function getId(): int
    {
        return $this->id;
    }

}
