<?php

declare(strict_types=1);

namespace Core\Lib;

class Helper
{
    public static function genPassword(): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_';

        return substr(str_shuffle($chars), 0, 16);
    }

    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function checkPassword(string $input_pw, string $db_pw): bool
    {
        return password_verify($input_pw, $db_pw);
    }
}
