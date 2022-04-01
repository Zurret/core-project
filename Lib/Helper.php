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
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($string, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public static function decrypt(string $string, string $key): string|bool
    {
        list($encrypted_data, $iv) = explode('::', base64_decode($string), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    }
    
}