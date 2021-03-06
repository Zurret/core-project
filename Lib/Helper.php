<?php

declare(strict_types=1);

function __(string $string, ?array $value = null): string
{
    if (is_null($value)) {
        return _($string);
    }

    return vsprintf(_($string), $value);
}

function removeHTML(string $string): string
{
    return strip_tags($string);
}

function isPositivInteger(int $int): bool
{
    return (bool) $int > 0;
}

function isNegativeInteger(int $int): bool
{
    return (bool) $int < 0;
}

function checkUrl(string $url): bool
{
    return (bool) filter_var($url, FILTER_VALIDATE_URL);
}

function betweenDates(string $date, string $start, string $end): bool
{
    $date = strtotime($date);
    $start = strtotime($start);
    $end = strtotime($end);

    return (bool) $date >= $start && $date <= $end;
}

function isValidDate(string $date): bool
{
    return (bool) strtotime($date) !== false;
}

function checkColor(string $color): bool
{
    return (bool) preg_match('/^#[a-f0-9]{6}$/i', $color);
}

function checkEmail(string $email): bool
{
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isPasswordValid(string $password): bool
{
    return (bool) preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}

function clearEmojis(string $string): string
{
    return preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $string);
}


/**
 * Encrypt and decrypt method
 * Used for Url
 */

function encrypt(mixed $value, string $key, bool $randomIv = false): string|bool
{
    try {
        if ($randomIv) {
            $iv = random_bytes(16);
            //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        } else {
            $iv = substr(hash('sha256', $key), 0, 16);
        }
        $encrypted = openssl_encrypt($value, 'aes-256-cbc', $key, 0, $iv);

        return rtrim(strtr(base64_encode($encrypted . '::' . $iv), '+/', '-_'), '=');
    } catch (Exception) {
        return false;
    }
}

function decrypt(mixed $value, string $key): string|bool
{
    try {
        $decoded = base64_decode(str_pad(strtr($value, '-_', '+/'), strlen($value) % 4, '='));
        $value = explode('::', $decoded);

        return openssl_decrypt($value[0], 'aes-256-cbc', $key, 0, $value[1]);
    } catch (Exception) {
        return false;
    }
}
