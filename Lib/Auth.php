<?php

declare(strict_types=1);

namespace Core\Lib;

use Core\Orm\Entity\AccountInterface;
use Core\Orm\Repository\AccountRepositoryInterface;

class Auth
{
    private AccountRepositoryInterface $accountRepository;

    private Session $session;

    private ?AccountInterface $account = null;

    protected string $sessionLogin = 'login';

    protected string $sessionAccount = 'account_id';

    protected string $session_string = 'account_sstr';

    protected string $cookie_string = 'account_cstr';

    protected int $cookie_lifetime = 60 * 60 * 24 * 7; // 7 days in seconds (default) 

    public function __construct(
        AccountRepositoryInterface $accountRepository,
        Session $session
    ) {
        $this->accountRepository = $accountRepository;
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
        $account = $this->accountRepository->getByEmail($email);

        if ($account && $this->checkPassword($password, $account->getPassword())) {
            $this->setAccount($account);
            $this->setSession();

            if ($remember) {
                $this->setCookies();
            }

            $this->accountRepository->save($this->getAccount());

            return true;
        }

        return false;
    }

    public function logout(): void
    {
        $this->getAccount()->setSessionString(null);
        $this->getAccount()->setCookieString(null);
        $this->accountRepository->save($this->getAccount());
        $this->session->deleteAllSessions();
        $this->unsetRememberMe();
        $this->account = null;
        header('Location: /');
    }

    public function setAccount(AccountInterface $account): void
    {
        $this->account = $account;
    }

    public function getAccount(): ?AccountInterface
    {
        if (!$this->account) {
            if ($this->session->getSession($this->sessionLogin) !== null && $account = $this->accountRepository->getByIdAndSession($this->session->getSession($this->sessionAccount) ?? 0, $this->session->getSession($this->session_string) ?? '')) {
                $this->setAccount($account);
            }
        }

        return $this->account;
    }

    public function isLoggedIn(): bool
    {
        if (!$this->getAccount()) {
            if ($this->session->getCookie($this->sessionLogin) !== null && $account = $this->accountRepository->getByIdandCookie((int) $this->session->getCookie($this->sessionAccount) ?? 0, (string) $this->session->getCookie($this->cookie_string) ?? '')) {
                $this->setAccount($account);
                $this->setSession();
                header('Location: /');
            }
        }

        return !($this->getAccount() === null);
    }

    public function isNotLoggedIn(): bool
    {
        return !$this->isLoggedIn();
    }

    public function checkAccessLevel(int $level): bool
    {
        return $this->getAccount()->getAccessLevel() >= $level;
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
        $this->session->setCookie($this->sessionAccount, $this->getAccount()->getId(), time() + $this->cookie_lifetime);
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
        $session = sha1(random_bytes(32) . $this->getAccount()->getId());
        $this->getAccount()->setSessionString($session);
        $this->getAccount()->setLastLogin(time());

        $this->session->setSession($this->sessionAccount, $this->getAccount()->getId());
        $this->session->setSession($this->session_string, $session);
        $this->session->setSession($this->sessionLogin, true);

        $this->accountRepository->save($this->getAccount());
    }

    private function setCookies(): void
    {
        $cookie = sha1(random_bytes(32) . $this->getAccount()->getId());
        $this->getAccount()->setCookieString($cookie);
        $this->setRememberMe($cookie);

        $this->accountRepository->save($this->getAccount());
    }
}
