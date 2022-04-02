<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

/**
 * @Entity(repositoryClass="Core\Orm\Repository\MapRepository")
 * @Table(
 *     name="core_map",
 *     indexes={
 *         @Index(name="coordinates_idx", columns={"cx","cy"}),
 *         @Index(name="coordinates_reverse_idx", columns={"cy","cx"}),
 *         @Index(name="map_field_type_idx", columns={"field_id"})
 *     }
 * )
 **/
class Map implements MapInterface
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @Column(type="integer") * */
    private int $cx = 0;

    /** @Column(type="integer") * */
    private int $cy = 0;

    /** @Column(type="integer") * */
    private int $field_id = 0;

    /** @Column(type="integer", nullable=true) * */
    private ?int $systems_id = 0;

    /**
     * @ManyToOne(targetEntity="StarSystem")
     * @JoinColumn(name="systems_id", referencedColumnName="id")
     */
    private ?StarSystem $starSystem;

    /**
     * @ManyToOne(targetEntity="MapField")
     * @JoinColumn(name="field_id", referencedColumnName="id")
     */
    private ?MapField $mapField;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCx(): int
    {
        return $this->cx;
    }

    public function setCx(int $cx): void
    {
        $this->cx = $cx;
    }

    public function getCy(): int
    {
        return $this->cy;
    }

    public function setCy(int $cy): void
    {
        $this->cy = $cy;
    }

    public function getStarSystem(): ?StarSystem
    {
        return $this->starSystem;
    }

    public function setStarSystem(?StarSystem $starSystem): void
    {
        $this->starSystem = $starSystem;
    }

    public function getMapField(): ?MapField
    {
        return $this->mapField;
    }

    public function setMapField(?MapField $mapField): void
    {
        $this->mapField = $mapField;
    }
}
