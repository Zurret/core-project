<?php

declare(strict_types=1);

namespace Core\Lib;

use Core\Orm\Entity\UserInterface;
use Core\Orm\Repository\UserRepositoryInterface;

class Auth
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

    public static function checkAccess(): void
    {
        if (!self::checkSession()) {
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
        Session::delSession('ACCOUNT_ID');
        Session::delSession('ACCOUNT_SSTR');
        Session::delSession('LOGIN');
        header('Location: /');
    }

    public static function doLogin(UserInterface $user): void
    {
        Session::setSession('ACCOUNT_ID', $user->getId());
        Session::setSession('ACCOUNT_SSTR', $user->getSession());
        Session::setSession('LOGIN', true);
    }

    public static function getUser()
    {
        global $container;
        $user = $container->get(UserRepositoryInterface::class);

        return $user->getByIdAndSession(Session::getSession('ACCOUNT_ID') ?? 0, Session::getSession('ACCOUNT_SSTR') ?? '');
    }
}
