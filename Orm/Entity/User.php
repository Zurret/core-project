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
    private int $id;

    /** @Column(type="string", length=255) */
    private string $email = '';

    /** @Column(type="string", length=255) */
    private string $password = '';

    /** @Column(type="string", length=255, nullable=true)) */
    private ?string $session = '';

    /** @Column(type="string", length=255, nullable=true)) */
    private ?string $cookie = '';

    /** @Column(type="integer", nullable=false, options={"default" : 0}) */
    private int $player_id = 0;

    /** @Column(type="integer", options={"default" : 0}) */
    private int $access_level = 0;

    /** @Column(type="integer", options={"default" : 0}) */
    private int $last_login = 0;

    /**
     * @ManyToOne(targetEntity="Player")
     * @JoinColumn(name="player_id", referencedColumnName="id")
     */
    private PlayerInterface $player;

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

    public function getSessionString(): ?string
    {
        return $this->session;
    }

    public function setSessionString(?string $session): UserInterface
    {
        $this->session = $session;

        return $this;
    }

    public function getCookieString(): ?string
    {
        return $this->cookie;
    }

    public function setCookieString(?string $cookie): UserInterface
    {
        $this->cookie = $cookie;

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

    public function setAccessLevel(int $access_level): UserInterface
    {
        $this->access_level = $access_level;

        return $this;
    }

    public function getLastLogin(): int
    {
        return $this->last_login;
    }

    public function setLastLogin(int $last_login): UserInterface
    {
        $this->last_login = $last_login;

        return $this;
    }
}
