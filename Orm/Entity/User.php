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

    /** @Column(type="string", length=255, nullable=true)) */
    private $session = '';

    /** @Column(type="integer", nullable=true) */
    private $player_id = '';

    /** @Column(type="integer", options={"default" : 0}) */
    private $access_level = 0;

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
}
