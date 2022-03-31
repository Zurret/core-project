<?php

declare(strict_types=1);

namespace Core\Lib;

class Session
{
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function deleteAll(): void
    {
        session_destroy();
    }

    public function checkSessionExist(string $key): bool
    {
        return self::get($key) === null;
    }
}
