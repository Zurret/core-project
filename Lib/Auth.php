<?php

declare(strict_types=1);

namespace Core\Lib;

use Core\Orm\Entity\UserInterface;
use Core\Orm\Repository\UserRepositoryInterface;

class Auth
{
    public static function genRandomPassword(int $length = 8): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function checkPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function checkAccessLevel(int $level): void
    {
        if (!Auth::checkSession()) {
            header('Location: /');
        } elseif (Auth::getUser()->getAccessLevel() < $level) {
            header('Location: /');
        }
    }

    private static function checkSession(): bool
    {
        if (!Session::getSession('LOGIN') && Session::getSession('ACCOUNT_ID') === null && Session::getSession('ACCOUNT_SSTR') === null) {
            return false;
        }

        return true;
    }

    public static function logout(): void
    {
        Session::delAllSession();
        header('Location: /');
    }

    public static function getUser()
    {
        global $container;
        $user = $container->get(UserRepositoryInterface::class);

        return $user->getByIdAndSession(Session::getSession('ACCOUNT_ID') ?? 0, Session::getSession('ACCOUNT_SSTR') ?? '');
    }
}
