<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

/**
 * @Entity(repositoryClass="Core\Orm\Repository\UserRepository")
 * @Table(
 *     name="core_user",
 *     indexes={
 *     }
 * )
 **/
class User implements UserInterface
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $email = '';

    /** @Column(type="string", length=255) */
    private $password = '';

    /** @Column(type="integer", nullable=true) */
    private $player_id = '';

    /** @Column(type="integer", options={"default" : 0}) */
    private $access_level = 0;

    public function getId(): int
    {
        return $this->id;
    }
}
