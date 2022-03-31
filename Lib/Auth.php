<?php

declare(strict_types=1);

namespace Core\Lib;

use Core\Orm\Entity\UserInterface;
use Core\Orm\Repository\UserRepositoryInterface;
use Core\Lib\Session;

class Auth
{
    private UserRepositoryInterface $userRepository;

    private Session $session;

    private ?UserInterface $user = null;

    public function __construct(
        UserRepositoryInterface $userRepository,
        Session $session
    ) {
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function checkPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->userRepository->getByEmail($email);

        if ($user && $this->checkPassword($password, $user->getPassword())) {
            $this->setUser($user);
            $session = $this->hashPassword(microtime().'-'.$this->getUser()->getId());
            $this->getUser()->setSession($session);
            $this->getUser()->setLastLogin(time());

            $this->session->set('ACCOUNT_ID', $this->getUser()->getId());
            $this->session->set('ACCOUNT_SSTR', $session);
            $this->session->set('LOGIN', true);

            $this->userRepository->save($this->getUser());
            return true;
        }

        return false;
    }

    public function logout(): void
    {
        $this->session->deleteAll();
        header('Location: /');
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getUser(): ?UserInterface
    {
        if ($this->session->get('LOGIN') && $user = $this->userRepository->getByIdAndSession($this->session->get('ACCOUNT_ID') ?? 0, $this->session->get('ACCOUNT_SSTR') ?? '')) {
                $this->setUser($user);
        }

        return $this->user;
    }

    public function isLoggedIn(): bool
    {
        return $this->getUser() === null ? false : true;
    }

    public function checkAccessLevel(int $level): bool
    {
        return $this->getUser()->getAccessLevel() >= $level;
    }
}
