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

    public function login(string $email, string $password, bool $remember = false): bool
    {
        $user = $this->userRepository->getByEmail($email);

        if ($user && $this->checkPassword($password, $user->getPassword())) {
            $this->setUser($user);
            $session = sha1(random_bytes(32) . $user->getId());
            $this->getUser()->setSessionString($session);
            $this->getUser()->setLastLogin(time());

            $this->session->setSession('ACCOUNT_ID', $this->getUser()->getId());
            $this->session->setSession('ACCOUNT_SSTR', $session);
            $this->session->setSession('LOGIN', true);

            if ($remember) {
                $cookie = sha1(random_bytes(32) . $user->getId());
                $this->getUser()->setCookieString($cookie);
                $this->setRememberMe($cookie);
            }

            $this->userRepository->save($this->getUser());

            return true;
        }

        return false;
    }

    public function logout(): void
    {
        $this->getUser()->setSessionString(null);
        $this->getUser()->setCookieString(null);
        $this->userRepository->save($this->getUser());
        $this->session->deleteAllSessions();
        $this->unsetRememberMe();
        $this->user = null;
        header('Location: /');
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getUser(): ?UserInterface
    {
        if (!$this->user) {
            if ($this->session->getSession('LOGIN') !== null && $user = $this->userRepository->getByIdAndSession($this->session->getSession('ACCOUNT_ID') ?? 0, $this->session->getSession('ACCOUNT_SSTR') ?? '')) {
                $this->setUser($user);
            }
        }

        return $this->user;
    }

    public function isLoggedIn(): bool
    {
        if (!$this->getUser()) {
            if ($this->session->getCookie('LOGIN') !== null && $user = $this->userRepository->getByIdandCookie((int) $this->session->getCookie('ACCOUNT_ID') ?? 0, (string) $this->session->getCookie('ACCOUNT_CSTR') ?? '')) {
                $this->setUser($user);
                // Set new Session
                $session = sha1(random_bytes(32) . $user->getId());
                $this->getUser()->setSessionString($session);
                $this->getUser()->setLastLogin(time());
    
                $this->session->setSession('ACCOUNT_ID', $this->getUser()->getId());
                $this->session->setSession('ACCOUNT_SSTR', $session);
                $this->session->setSession('LOGIN', true);
                
                $this->userRepository->save($this->getUser());
            }
        }
        return !($this->getUser() === null);
    }

    public function isNotLoggedIn(): bool
    {
        return !$this->isLoggedIn();
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

    public function setRememberMe($cookie): void
    {
        $this->session->setCookie('LOGIN', true, time() + 60 * 60 * 24 * 7);
        $this->session->setCookie('ACCOUNT_ID', $this->getUser()->getId(), time() + 60 * 60 * 24 * 7);
        $this->session->setCookie('ACCOUNT_CSTR', $cookie, time() + 60 * 60 * 24 * 7);
    }

    public function unsetRememberMe(): void
    {
        $this->session->deleteCookie('LOGIN');
        $this->session->deleteCookie('ACCOUNT_ID');
        $this->session->deleteCookie('ACCOUNT_CSTR');
    }
}
