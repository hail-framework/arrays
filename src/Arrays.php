<?php
/**
 * Some code from
 * https://github.com/laravel/framework/blob/5.8/src/Illuminate/Support/Arr.php
 * Copyright (c) Taylor Otwell
 */

namespace Hail\Arrays;

/**
 * Class Arrays
 *
 * @package Hail\Util
 * @author  FENG Hao <flyinghail@msn.com>
 */
class Arrays
{
    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param array  $array
     * @param string $prepend
     *
     * @return array
     */
    public static function flatten(array $array, string $prepend = ''): array
    {
        $results = [
            0 => [],
        ];

        foreach ($array as $key => $value) {
            if (\is_array($value) && !empty($value)) {
                $results[] = self::flatten($value, $prepend . $key . '.');
            } else {
                $results[0][$prepend . $key] = $value;
            }
        }

        return \array_merge(...$results);
    }

    /**
     * Get an item from an array using "dot" notation.
     */
    public static function get(array $array, string $key = null): mixed
    {
        if ($key === null) {
            return $array;
        }

        if ($array === []) {
            return null;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (\explode('.', $key) as $segment) {
            if (\is_array($array) && isset($array[$segment])) {
                $array = $array[$segment];
            } else {
                return null;
            }
        }

        return $array;
    }

    /**
     * Set an array item to a given value using "dot" notation.
     */
    public static function set(array &$array, string $key, mixed $value): void
    {
        foreach (\explode('.', $key) as $k) {
            if (!isset($array[$k]) || !\is_array($array[$k])) {
                $array[$k] = [];
            }
            $array = &$array[$k];
        }

        $array = $value;
    }

    /**
     * Check if an item or items exist in an array using "dot" notation.
     */
    public static function has(array $array, string $key): bool
    {
        if ($array === []) {
            return false;
        }

        if (\array_key_exists($key, $array)) {
            return true;
        }

        foreach (\explode('.', $key) as $k) {
            if (\is_array($array) && \array_key_exists($k, $array)) {
                $array = $array[$k];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Remove one or many array items from a given array using "dot" notation.
     */
    public static function delete(array &$array, string ...$keys): void
    {
        if ($keys === []) {
            return;
        }

        $original = &$array;
        foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
            if (isset($array[$key])) {
                unset($array[$key]);
                continue;
            }

            // clean up before each pass
            $array = &$original;

            $parts = \explode('.', $key);
            $delKey = \array_pop($parts);
            foreach ($parts as $part) {
                if (isset($array[$part]) && \is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[$delKey]);
        }
    }

    /**
     * Determines if an array is associative.
     *
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     */
    public static function isAssoc(array $array): bool
    {
        if ($array === []) {
            return false;
        }

        if (!isset($array[0])) {
            return true;
        }

        $keys = \array_keys($array);

        return \array_keys($keys) !== $keys;
    }

    public static function filter(array $array): array
    {
        return \array_filter($array, static fn ($v) => $v !== false && $v !== null);
    }

    /**
     * Array shift no reindex, and return key (use for assoc array)
     */
    public static function shift(array &$array): ?array
    {
        if ($array === []) {
            return null;
        }

        $key = \array_key_first($array);
        $value = $array[$key];

        unset($array[$key]);

        return [$value, $key];
    }

    /**
     * Convert the array into a query string.
     */
    public static function query(array $array): string
    {
        return \http_build_query($array, null, '&', PHP_QUERY_RFC3986);
    }
}
