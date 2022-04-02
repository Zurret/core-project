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

    /** @Column(type="integer", options={"default" : 0}) */
    private $level = 0;

    /** @Column(type="integer", options={"default" : 100}) */
    private $external_reputation = 100;

    /** @Column(type="integer", options={"default" : 0}) */
    private $internal_reputation = 0;

    /** @Column(type="boolean", options={"default" : false}) */
    private $npc = false;

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

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): PlayerInterface
    {
        $this->level = $level;

        return $this;
    }

    public function getExternalReputation(): int
    {
        return $this->external_reputation;
    }

    public function setExternalReputation(int $external_reputation): PlayerInterface
    {
        $this->external_reputation = $external_reputation;

        return $this;
    }

    public function addExternalReputation(int $external_reputation): PlayerInterface
    {
        $this->external_reputation += $external_reputation;

        return $this;
    }

    public function getInternalReputation(): int
    {
        return $this->internal_reputation;
    }

    public function setInternalReputation(int $internal_reputation): PlayerInterface
    {
        $this->internal_reputation = $internal_reputation;

        return $this;
    }

    public function addInternalReputation(int $internal_reputation): PlayerInterface
    {
        $this->internal_reputation += $internal_reputation;

        return $this;
    }

    public function getReputation(): int
    {
        return $this->external_reputation + $this->internal_reputation;
    }

    public function isNpc(): bool
    {
        return $this->npc;
    }

    public function setNpc(bool $npc): PlayerInterface
    {
        $this->npc = $npc;

        return $this;
    }

    public function isNewbie(): bool
    {
        return (bool) $this->level < 1;
    }
}
