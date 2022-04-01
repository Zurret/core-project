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

    public static function getFile(string $key): array
    {
        return $_FILES[$key] ?? null;
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

    public static function postArray(string $key): array
    {
        return (array) self::getPost($key) ?? null;
    }

    public static function getJson(string $key): array
    {
        return json_decode(self::getQuery($key) ?? '[]', true) ?? [];
    }

    public static function postJson(string $key): array
    {
        return json_decode(self::getPost($key) ?? '[]', true) ?? [];
    }

    public static function getFileName(string $key): string
    {
        return self::getFile($key)['name'] ?? null;
    }

    public static function getFileType(string $key): string
    {
        return self::getFile($key)['type'] ?? null;
    }

    public static function getFileSize(string $key): int
    {
        return self::getFile($key)['size'] ?? null;
    }


}
