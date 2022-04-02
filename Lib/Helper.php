<?php

declare(strict_types=1);

namespace Core\Lib;

class Helper
{
    public static function removeHTML(string $string): string
    {
        return (string) strip_tags($string);
    }

    public static function isPositivInteger(int $int): bool
    {
        return (bool) $int > 0;
    }

    public static function isNegativeInteger(int $int): bool
    {
        return (bool) $int < 0;
    }

    public static function checkUrl(string $url): bool
    {
        return (bool) filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function betweenDates(string $date, string $start, string $end): bool
    {
        $date = strtotime($date);
        $start = strtotime($start);
        $end = strtotime($end);

        return (bool) $date >= $start && $date <= $end;
    }

    public static function isValidDate(string $date): bool
    {
        return (bool) strtotime($date) !== false;
    }

    public static function checkColor(string $color): bool
    {
        return (bool) preg_match('/^#[a-f0-9]{6}$/i', $color);
    }

    public static function checkEmail(string $email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isPasswordValid(string $password): bool
    {
        return (bool) preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    }

    public static function encrypt(string $string, string $key): string|bool
    {
        try {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encrypted = openssl_encrypt($string, 'aes-256-cbc', $key, 0, $iv);
            return rtrim(strtr(base64_encode($encrypted . '::' . $iv), '+/', '-_'), '=');
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function decrypt(string $string, string $key): string|bool
    {
        try {
            $decoded = base64_decode(str_pad(strtr($string, '-_', '+/'), strlen($string) % 4, '=', STR_PAD_RIGHT));
            $string = explode('::', $decoded);
            return openssl_decrypt($string[0], 'aes-256-cbc', $key, 0, $string[1]);
        } catch (\Exception $e) {
            return false;
        }
    }
}
