<?php

namespace Core\Lib;

// Eventlistener class
class Event
{
    private static array $events = [];

    public static function listen($name, $callback)
    {
        self::set($name, $callback);
    }

    public static function trigger($name, $argument = null)
    {
        foreach (self::get($name) as $callback) {
            if ($argument && is_array($argument)) {
                call_user_func_array($callback, $argument);
            } elseif ($argument && !is_array($argument)) {
                call_user_func($callback, $argument);
            } else {
                call_user_func($callback);
            }
        }
    }

    private static function set($name, $callback)
    {
        self::$events[$name][] = $callback;
    }

    private static function get($name)
    {
        return self::$events[$name];
    }
}
