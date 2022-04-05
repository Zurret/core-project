<?php

declare(strict_types=1);

namespace Core\Lib;

/*
 * Copyright (c) 2012 Jeremy Perret
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

use Exception;
use LogicException;

class Ubench
{
    protected string|float $start_time;
    protected string|float $end_time;
    protected string|float $memory_usage;

    /**
     * Sets start microtime.
     */
    public function start(): void
    {
        $this->start_time = microtime(true);
    }

    /**
     * Sets end microtime.
     *
     * @throws Exception
     *
     * @return $this
     */
    public function end(): static
    {
        if (! $this->hasStarted()) {
            throw new LogicException('You must call start()');
        }

        $this->end_time = microtime(true);
        $this->memory_usage = memory_get_usage(true);

        return $this;
    }

    /**
     * Returns the elapsed time, readable or not.
     *
     * @param string|null $format The format to display (printf format)
     */
    public function getTime(bool $raw = false, ?string $format = null): float|string
    {
        if (! $this->hasStarted()) {
            throw new LogicException('You must call start()');
        }

        if (! $this->hasEnded()) {
            throw new LogicException('You must call end()');
        }

        $elapsed = $this->end_time - $this->start_time;

        return $raw ? $elapsed : self::readableElapsedTime($elapsed, $format);
    }

    /**
     * Returns the memory usage at the end checkpoint.
     *
     * @param string|null $format The format to display (printf format)
     */
    public function getMemoryUsage(bool $raw = false, ?string $format = null): string|float
    {
        return $raw ? $this->memory_usage : self::readableSize((int) $this->memory_usage, $format);
    }

    /**
     * Returns the memory peak, readable or not.
     *
     * @param string|null $format The format to display (printf format)
     */
    public function getMemoryPeak(bool $raw = false, ?string $format = null): string|float
    {
        $memory = memory_get_peak_usage(true);

        return $raw ? $memory : self::readableSize($memory, $format);
    }

    /**
     * Wraps a callable with start() and end() calls.
     *
     * Additional arguments passed to this method will be passed to
     * the callable.
     *
     * @throws Exception
     */
    public function run(callable $callable): mixed
    {
        $arguments = func_get_args();
        array_shift($arguments);
        $this->start();
        $result = call_user_func_array($callable, $arguments);
        $this->end();

        return $result;
    }

    /**
     * Returns a human readable memory size.
     *
     * @param string|null $format The format to display (printf format)
     */
    public static function readableSize(int $size, ?string $format = null, int $round = 3): string
    {
        $mod = 1024;
        if (is_null($format)) {
            $format = '%.2f%s';
        }

        $units = explode(' ', 'B Kb Mb Gb Tb');

        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }

        if ($i === 0) {
            $format = preg_replace('/(%.[\d]+f)/', '%d', $format);
        }

        return sprintf($format, round($size, $round), $units[$i]);
    }

    /**
     * Returns a human readable elapsed time.
     *
     * @param string|null $format    The format to display (printf format)
     */
    public static function readableElapsedTime(float $microtime, ?string $format = null, int $round = 3): string
    {
        if (is_null($format)) {
            $format = '%.3f%s';
        }

        if ($microtime >= 1) {
            $unit = 's';
            $time = round($microtime, $round);
        } else {
            $unit = 'ms';
            $time = round($microtime * 1000);
            $format = preg_replace('/(%.[\d]+f)/', '%d', $format);
        }

        return sprintf($format, $time, $unit);
    }

    public function hasEnded(): bool
    {
        return isset($this->end_time);
    }

    public function hasStarted(): bool
    {
        return isset($this->start_time);
    }
}
