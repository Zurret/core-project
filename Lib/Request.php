<?php

declare(strict_types=1);

namespace Core\Lib;

use Exception;

class Request
{

    public static function getRequest(string $key): string
    {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }

        throw new Exception('Request key not found');
    }

    public static function getQuery(): ?array
    {
        return $_GET ?? null;
    }

    public static function getQueryParam(string $key): ?string
    {
        return $_GET[$key] ?? null;
    }

    public static function setQuery(string $var, mixed $value): void
    {
        $_GET[$var] = $value;
    }

    public static function getPost(): ?array
    {
        return $_POST ?? null;
    }

    public static function getPostParam(string $key): ?string
    {
        return $_POST[$key] ?? null;
    }

    public static function setPost(string $var, mixed $value): void
    {
        $_POST[$var] = $value;
    }

    public static function getFile(): ?array
    {
        return $_FILES ?? null;
    }

    public static function getFileParam(string $key): ?array
    {
        return $_FILES[$key] ?? null;
    }

    public static function setFile(string $var, mixed $value): void
    {
        $_FILES[$var] = $value;
    }

    public static function checkFileSize(string $key, int $size): bool
    {
        $file = self::getFileParam($key);

        if ($file['size'] > $size) {
            return false;
        }

        return true;
    }

    public static function checkFileType(string $key, string $type): bool
    {
        $file = self::getFileParam($key);

        if ($file['type'] !== $type) {
            return false;
        }

        return true;
    }

    public static function isGet(): bool
    {
        return self::isRequest('GET');
    }

    public static function isPost(): bool
    {
        return self::isRequest('POST');
    }

    public static function isFile(): bool
    {
        return self::isRequest('FILE');
    }

    public static function isRequest(string $method): bool
    {
        return $_SERVER['REQUEST_METHOD'] === $method;
    }

    public static function has(string $key): bool
    {
        return self::getRequest($key) === null;
    }

    /**
     * @throws Exception
     */
    public static function getVarByMethod($method, $var, bool $fatal = false)
    {
        if (!@array_key_exists($var, $method)) {
            if ($fatal === true) {
                throw new Exception($var);
            }

            return false;
        }

        return $method[$var];
    }

    /**
     * @throws Exception
     */
    public static function getInt($var, $std = 0)
    {
        $int = self::getVarByMethod(self::getQuery(), $var);
        if (strlen((string) $int) === 0) {
            return $std;
        }

        return self::returnInt($int);
    }

    /**
     * @throws Exception
     */
    public static function getIntFatal($var): int
    {
        $int = self::getVarByMethod(self::getQuery(), $var, true);

        return self::returnInt($int);
    }

    /**
     * @throws Exception
     */
    public static function postInt($var): int
    {
        $int = self::getVarByMethod(self::getPost(), $var);

        return self::returnInt($int);
    }

    /**
     * @throws Exception
     */
    public static function postIntFatal($var): int
    {
        $int = self::getVarByMethod(self::getPost(), $var, true);

        return self::returnInt($int);
    }

    /**
     * @throws Exception
     */
    public static function getString($var)
    {
        return self::getVarByMethod(self::getQuery(), $var);
    }

    /**
     * @throws Exception
     */
    public static function postString($var)
    {
        return self::getVarByMethod(self::getPost(), $var);
    }

    /**
     * @throws Exception
     */
    public static function indString($var)
    {
        $value = self::getVarByMethod(self::getPost(), $var);
        if ($value) {
            return $value;
        }

        return self::getVarByMethod(self::getQuery(), $var);
    }

    /**
     * @throws Exception
     */
    public static function indInt($var): int
    {
        $value = self::getVarByMethod(self::getPost(), $var);
        if ($value) {
            return self::returnInt($value);
        }

        return self::returnInt(self::getVarByMethod(self::getQuery(), $var));
    }

    /**
     * @throws Exception
     */
    public static function postStringFatal($var)
    {
        return self::getVarByMethod(self::getPost(), $var, true);
    }

    /**
     * @throws Exception
     */
    public static function getStringFatal($var)
    {
        return self::getVarByMethod(self::getQuery(), $var, true);
    }

    /**
     * @throws Exception
     */
    public static function postArrayFatal($var): array
    {
        return self::returnArray(self::getVarByMethod(self::getPost(), $var, true));
    }

    /**
     * @throws Exception
     */
    public static function postArray($var): array
    {
        return self::returnArray(self::getVarByMethod(self::getPost(), $var));
    }

    public static function returnInt($result): int
    {
        return intval($result ?? 0);
    }

    public static function returnArray(array $result): array
    {
        return $result;
    }

    public static function isAjaxRequest(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
