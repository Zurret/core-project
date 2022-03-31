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
    
}
