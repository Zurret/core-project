<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

use Core\Orm\Repository\MapRepositoryInterface;
use Core\Orm\Repository\StarSystemMapRepositoryInterface;

/**
 * @Entity(repositoryClass="Core\Orm\Repository\StarSystemRepository")
 * @Table(
 *     name="core_systems",
 *     indexes={
 *         @Index(name="coordinate_idx", columns={"cx","cy"})
 *     }
 * )
 **/
class StarSystem implements StarSystemInterface
{
    
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** @Column(type="smallint") * */
    private $cx = 0;

    /** @Column(type="smallint") * */
    private $cy = 0;

    /** @Column(type="integer") * */
    private $type = 0;

    /** @Column(type="string") */
    private $name = '';

    /** @Column(type="smallint") * */
    private $max_x = 0;

    /** @Column(type="smallint") * */
    private $max_y = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCx(): int
    {
        return $this->cx;
    }

    public function getCy(): int
    {
        return $this->cy;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxX(): int
    {
        return $this->max_x;
    }

    public function getMaxY(): int
    {
        return $this->max_y;
    }
}