<?php

namespace Hail\Arrays;

trait ArrayAccessTrait
{
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }
}