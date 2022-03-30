<?php

declare(strict_types=1);

namespace Core\Lib;

class Session
{
    public static function setSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function getSession(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public static function delSession(string $key): void
    {
        self::setSession($key, null);
    }

    public static function checkSessionExist(string $key): bool
    {
        return !empty(self::getSession($key)) && !is_null(self::getSession($key));
    }

    public static function setCookie(string $key, string $value, int $lifetime = 3600): void
    {
        setcookie($key, $value, time() + $lifetime);
    }

    public static function getCookie(string $key): mixed
    {
        return $_COOKIE[$key] ?? null;
    }

    public static function checkCookieExist(string $key): bool
    {
        return !empty(self::getCookie($key)) && !is_null(self::getCookie($key));
    }

    public static function delCookie(string $key): void
    {
        self::setCookie($key, '', -3600);
    }

}
