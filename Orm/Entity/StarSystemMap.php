<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

/**
 * @Entity(repositoryClass="Stu\Orm\Repository\StarSystemMapRepository")
 *
 * @Table(
 *     name="core_system_map",
 *     uniqueConstraints={@UniqueConstraint(name="system_coordinates_idx", columns={"sx", "sy", "systems_id"})}
 * )
 */
class StarSystemMap implements StarSystemMapInterface
{
    /**
     * @Id
     *
     * @Column(type="integer")
     *
     * @GeneratedValue(strategy="IDENTITY")
     */
    private int $id;
    /**
     * @ManyToOne(targetEntity="StarSystem", inversedBy="maps")
     *
     * @JoinColumn(name="systems_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private StarSystemInterface $system;
    /**
     * @Column(type="integer", nullable=false)
     */
    private int $sx;
    /**
     * @Column(type="integer", nullable=false)
     */
    private int $sy;
    /**
     * @Column(type="integer", nullable=false)
     */
    private int $type;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSystem(): StarSystemInterface
    {
        return $this->system;
    }

    public function getSx(): int
    {
        return $this->sx;
    }

    public function setSx(int $sx): StarSystemMapInterface
    {
        $this->sx = $sx;

        return $this;
    }

    public function getSy(): int
    {
        return $this->sy;
    }

    public function setSy(int $sy): StarSystemMapInterface
    {
        $this->sy = $sy;

        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): StarSystemMapInterface
    {
        $this->type = $type;

        return $this;
    }
}
