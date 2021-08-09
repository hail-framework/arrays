<?php

namespace Hail\Arrays;

/**
 * Class Dot
 *
 * @package Hail\Arrays
 * @author  FENG Hao <flyinghail@msn.com>
 */
class Dot implements \ArrayAccess, \Countable, \IteratorAggregate, \JsonSerializable
{
    use ArrayAccessTrait;

    private array $array;

    private ?int $count = null;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function set(string $key, mixed $value): void
    {
        Arrays::set($this->array, $key, $value);
        $this->count = null;
    }

    public function get(string $key): mixed
    {
        return Arrays::get($this->array, $key);
    }

    public function delete(string $key): void
    {
        Arrays::delete($this->array, $key);
        $this->count = null;
    }

    public function flatten(): array
    {
        return Arrays::flatten($this->array);
    }

    public function count(): int
    {
        return $this->count ??= \count($this->array);
    }

    public function jsonSerialize(): string
    {
        return \json_encode($this->array, \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_SLASHES | \JSON_PRESERVE_ZERO_FRACTION);
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->array);
    }
}
