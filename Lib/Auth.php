<?php

declare(strict_types=1);

namespace Core\Lib;

use Core\Orm\Entity\UserInterface;
use Core\Orm\Repository\UserRepositoryInterface;

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
            $this->getUser()->setSessionString($session);
            $this->getUser()->setLastLogin(time());

            $this->session->setSession('ACCOUNT_ID', $this->getUser()->getId());
            $this->session->setSession('ACCOUNT_SSTR', $session);
            $this->session->setSession('LOGIN', true);

            $this->userRepository->save($this->getUser());

            return true;
        }

        return false;
    }

    public function logout(): void
    {
        $this->session->deleteAllSessions();
        $this->session->deleteCookie('USERID');
        $this->session->deleteCookie('SSTR');
        $this->session->deleteCookie('LOGIN');
        $this->user = null;
        header('Location: /');
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getUser(): ?UserInterface
    {
        if ($this->session->getSession('LOGIN') && $user = $this->userRepository->getByIdAndSession($this->session->getSession('ACCOUNT_ID') ?? 0, $this->session->getSession('ACCOUNT_SSTR') ?? '')) {
            $this->setUser($user);
        }

        return $this->user;
    }

    public function isLoggedIn(): bool
    {
        // TODO: Implement Cookie check
        return $this->getUser() === null ? false : true;
    }

    public function checkAccessLevel(int $level): bool
    {
        return $this->getUser()->getAccessLevel() >= $level;
    }

    public function checkAccessLevelOrDie(int $level): void
    {
        if (!$this->checkAccessLevel($level)) {
            exit('Access denied');
        }
    }

    public function setRememberMe(): void
    {
        $this->session->setCookie('LOGIN', true, time() + 60 * 60 * 24 * 7);
        $this->session->setCookie('USERID', $this->getUser()->getId(), time() + 60 * 60 * 24 * 7);
        $this->session->setCookie('SSTR', $this->getUser()->getSessionString(), time() + 60 * 60 * 24 * 7);
    }
}
