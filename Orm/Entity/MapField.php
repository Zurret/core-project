<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

/**
 * @Entity(repositoryClass="Core\Orm\Repository\MapFieldRepository")
 * @Table(
 *     name="core_map_field",
 *     indexes={
 *          @Index(name="map_fields_type_idx", columns={"type"})
 *     }
 * )
 **/
class MapField implements MapFieldInterface
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @Column(type="integer") * */
    private int $type = 0;

    /** @Column(type="boolean") * */
    private bool $is_system = false;

    /** @Column(type="smallint") * */
    private int $ecost = 0;

    /** @Column(type="string") */
    private string $name = '';

    /** @Column(type="integer", nullable=true) * */
    private ?int $colonies_classes_id = 0;

    /** @Column(type="smallint") * */
    private int $damage = 0;

    /** @Column(type="smallint") * */
    private int $x_damage = 0;

    /** @Column(type="smallint") * */
    private int $x_damage_system = 0;

    /** @Column(type="boolean") * */
    private bool $view = false;

    /** @Column(type="boolean") * */
    private bool $passable = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getIsSystem(): bool
    {
        return $this->is_system;
    }

    public function setIsSystem(bool $is_system): void
    {
        $this->is_system = $is_system;
    }

    public function getEcost(): int
    {
        return $this->ecost;
    }

    public function setEcost(int $ecost): void
    {
        $this->ecost = $ecost;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getColoniesClassesId(): int
    {
        return $this->colonies_classes_id;
    }

    public function setColoniesClassesId(int $colonies_classes_id): void
    {
        $this->colonies_classes_id = $colonies_classes_id;
    }

    public function getDamage(): int
    {
        return $this->damage;
    }

    public function setDamage(int $damage): void
    {
        $this->damage = $damage;
    }

    public function getXDamage(): int
    {
        return $this->x_damage;
    }

    public function setXDamage(int $x_damage): void
    {
        $this->x_damage = $x_damage;
    }

    public function getXDamageSystem(): int
    {
        return $this->x_damage_system;
    }

    public function setXDamageSystem(int $x_damage_system): void
    {
        $this->x_damage_system = $x_damage_system;
    }

    public function getView(): bool
    {
        return $this->view;
    }

    public function setView(bool $view): void
    {
        $this->view = $view;
    }

    public function getPassable(): bool
    {
        return $this->passable;
    }

    public function setPassable(bool $passable): void
    {
        $this->passable = $passable;
    }
}
