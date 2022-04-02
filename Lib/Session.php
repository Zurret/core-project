<?php

declare(strict_types=1);

namespace Core\Lib;

class Session
{
    public function setSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function getSession(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function deleteAllSessions(): void
    {
        session_destroy();
    }

    public function checkSessionExist(string $key): bool
    {
        return self::getSession($key) === null;
    }

    public function setCookie(string $key, mixed $value, int $expire = 0): void
    {
        setcookie($key, (string) $value, $expire);
    }

    public function getCookie(string $key): mixed
    {
        return $_COOKIE[$key] ?? null;
    }

    public function deleteCookie(string $key): void
    {
        setcookie($key, '', time() - 3600);
    }

    public function checkCookieExist(string $key): bool
    {
        return self::getCookie($key) === null;
    }

    public function setSessionCookie(string $key, mixed $value, int $expire = 0): void
    {
        self::setCookie($key, $value, $expire);
        self::setSession($key, $value);
    }

    public function getSessionCookie(string $key): mixed
    {
        return self::getSession($key) ?? self::getCookie($key);
    }
}
