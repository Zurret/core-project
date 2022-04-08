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

    protected string $sessionLogin = 'login';

    protected string $sessionAccount = 'account_id';

    protected string $session_string = 'account_sstr';

    protected string $cookie_string = 'account_cstr';

    protected int $cookie_lifetime = 60 * 60 * 24 * 7; // 7 days in seconds (default) 

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
            $this->setSession();

            if ($remember) {
                $this->setCookies();
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
            if ($this->session->getSession($this->sessionLogin) !== null && $user = $this->userRepository->getByIdAndSession($this->session->getSession($this->sessionAccount) ?? 0, $this->session->getSession($this->session_string) ?? '')) {
                $this->setUser($user);
            }
        }

        return $this->user;
    }

    public function isLoggedIn(): bool
    {
        if (!$this->getUser()) {
            if ($this->session->getCookie($this->sessionLogin) !== null && $user = $this->userRepository->getByIdandCookie((int) $this->session->getCookie($this->sessionAccount) ?? 0, (string) $this->session->getCookie($this->cookie_string) ?? '')) {
                $this->setUser($user);
                $this->setSession();
                header('Location: /');
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
            exit(__('Access denied'));
        }
    }

    public function setRememberMe($cookie): void
    {
        $this->session->setCookie($this->sessionLogin, true, time() + $this->cookie_lifetime);
        $this->session->setCookie($this->sessionAccount, $this->getUser()->getId(), time() + $this->cookie_lifetime);
        $this->session->setCookie($this->cookie_string, $cookie, time() + $this->cookie_lifetime);
    }

    public function unsetRememberMe(): void
    {
        $this->session->deleteCookie($this->sessionLogin);
        $this->session->deleteCookie($this->sessionAccount);
        $this->session->deleteCookie($this->cookie_string);
    }

    private function setSession(): void
    {
        $session = sha1(random_bytes(32) . $this->getUser()->getId());
        $this->getUser()->setSessionString($session);
        $this->getUser()->setLastLogin(time());

        $this->session->setSession($this->sessionAccount, $this->getUser()->getId());
        $this->session->setSession($this->session_string, $session);
        $this->session->setSession($this->sessionLogin, true);

        $this->userRepository->save($this->getUser());
    }

    private function setCookies(): void
    {
        $cookie = sha1(random_bytes(32) . $this->getUser()->getId());
        $this->getUser()->setCookieString($cookie);
        $this->setRememberMe($cookie);

        $this->userRepository->save($this->getUser());
    }
}
