<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

/**
 * @Entity(repositoryClass="Core\Orm\Repository\UserRepository")
 * @Table(
 *     name="core_user",
 *     indexes={
 *         @Index(name="user_player_idx", columns={"player_id"})
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

    /** @Column(type="string", length=255, nullable=true)) */
    private $session = '';

    /** @Column(type="integer", nullable=false, options={"default" : 0}) */
    private $player_id = 0;

    /** @Column(type="integer", options={"default" : 0}) */
    private $access_level = 0;

    /**
     * @ManyToOne(targetEntity="Player")
     * @JoinColumn(name="player_id", referencedColumnName="id")
     */
    private $player;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEMail(): string
    {
        return $this->email;
    }

    public function setEMail(string $email): UserInterface
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): UserInterface
    {
        $this->password = $password;

        return $this;
    }

    public function getSession(): string
    {
        return $this->session;
    }

    public function setSession(string $session): UserInterface
    {
        $this->session = $session;

        return $this;
    }

    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }

    public function setPlayer(PlayerInterface $player): UserInterface
    {
        $this->player = $player;

        return $this;
    }

    public function getAccessLevel(): int
    {
        return $this->access_level;
    }
}
