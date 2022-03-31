<?php

declare(strict_types=1);

namespace Core\Lib;

class Request
{
    public static function getQuery(string $key): ?string
    {
        return $_GET[$key] ?? null;
    }

    public static function getPost(string $key): ?string
    {
        return $_POST[$key] ?? null;
    }

    public static function getString(string $key): ?string
    {
        return self::getQuery($key) ?? null;
    }

    public static function postString(string $key): ?string
    {
        return self::getPost($key) ?? null;
    }

    public static function getInt(string $key): int
    {
        return (int) self::getQuery($key) ?? null;
    }

    public static function postInt(string $key): int
    {
        return (int) self::getPost($key) ?? null;
    }

    public static function getBool(string $key): bool
    {
        return (bool) self::getQuery($key) ?? null;
    }

    public static function postBool(string $key): bool
    {
        return (bool) self::getPost($key) ?? null;
    }

    public static function getArray(string $key): array
    {
        return (array) self::getQuery($key) ?? null;
    }
}
