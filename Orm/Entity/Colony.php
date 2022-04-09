<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

/**
 * @Entity(repositoryClass="Core\Orm\Repository\ColonyRepository")
 * @Table(
 *     name="core_colony",
 *     indexes={
 *         @Index(name="colony_player_idx", columns={"player_id"}),
 *         @Index(name="colony_system_map_idx", columns={"starsystem_map_id"})
 *     }
 * )
 */
class Colony implements ColonyInterface
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @Column(type="integer") */
    private int $player_id = 0;

    /** @Column(type="integer") */
    private int $type_id = 0;

    /** @Column(type="integer") */
    private int $starsystem_map_id = 0;

    /** @Column(type="integer") */
    private int $planet_map_id = 0;

    /** @Column(type="integer") */
    private int $x_size = 0;

    /** @Column(type="integer") */
    private int $y_size = 0;

    /** @Column(type="integer") */
    private int $level = 0;

    /**
     * @ManyToOne(targetEntity="Player", inversedBy="colonies")
     * @JoinColumn(name="player_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private PlayerInterface $player;

    /**
     * @ManyToOne(targetEntity="StarSystemMap", inversedBy="colonies")
     * @JoinColumn(name="starsystem_map_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private StarSystemMapInterface $starsystemMap;

    /**
     * @ManyToOne(targetEntity="PlanetMap", inversedBy="colonies")
     * @JoinColumn(name="planet_map_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private PlanetMapInterface $planetMap;

    /**
     * @ManyToOne(targetEntity="ColonyType", inversedBy="colonies")
     * @JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private ColonyTypeInterface $type;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlayerId(): int
    {
        return $this->player_id;
    }

    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }

    public function setAccount(PlayerInterface $player): ColonyInterface
    {
        $this->player = $player;

        return $this;
    }

    public function getTypeId(): int
    {
        return $this->type_id;
    }

    public function getStarsystemMapId(): int
    {
        return $this->starsystem_map_id;
    }

    public function getPlanetMapId(): int
    {
        return $this->planet_map_id;
    }

    public function getXSize(): int
    {
        return $this->x_size;
    }

    public function setXSize(int $x_size): Colony
    {
        $this->x_size = $x_size;

        return $this;
    }

    public function getYSize(): int
    {
        return $this->y_size;
    }

    public function setYSize(int $y_size): Colony
    {
        $this->y_size = $y_size;

        return $this;
    }

    public function getLevel(): int
    {
        return $this->level;
    }
}
