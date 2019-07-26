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
    use ArrayTrait;

    /**
     * @var array
     */
    private $array;

    /**
     * @var int
     */
    private $count;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function set(string $key, $value): void
    {
        Arrays::set($this->array, $key, $value);
        $this->count = null;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return Arrays::get($this->array, $key);
    }

    /**
     * @param string $key
     */
    public function delete(string $key): void
    {
        Arrays::delete($this->array, $key);
        $this->count = null;
    }

    public function flatten(): array
    {
        return Arrays::flatten($this->array);
    }

    public function count()
    {
        if ($this->count === null) {
            $this->count = \count($this->array);
        }

        return $this->count;
    }

    public function jsonSerialize(): string
    {
        return \json_encode($this->array, \JSON_UNESCAPED_SLASHES | \JSON_PRESERVE_ZERO_FRACTION);
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->array);
    }
}
