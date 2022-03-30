<?php

declare(strict_types=1);

namespace Core\Lib;


class Auth
{
    public static function checkLogin(): bool
    {
        if (Session::checkSessionExist('user_session')) {
            return true;
        }

        return false;
    }

    public static function doLogin(string $email, string $password): string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'mail_invalid';
        }

        return 'done';
    }
}
