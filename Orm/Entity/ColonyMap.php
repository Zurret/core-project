<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

/**
 * @Entity(repositoryClass="Core\Orm\Repository\MapRepository")
 *
 * @Table(
 *     name="core_colony_map",
 *     indexes={
 *     }
 * )
 */
class ColonyMap implements ColonyMapInterface
{
    /**
     * @Id
     *
     * @Column(type="integer")
     *
     * @GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @Column(type="string", length=255) */
    private string $map; // JSON?

    /**
     * @ManyToOne(targetEntity="Colony", inversedBy="maps")
     *
     * @JoinColumn(name="colony_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private ColonyInterface $colony;

    public function getId(): int
    {
        return $this->id;
    }
}
