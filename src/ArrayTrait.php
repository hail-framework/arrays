<?php
namespace Hail\Arrays;

/**
 * Class ArrayTrait
 *
 * @package Hail\Util
 * @author Feng Hao <flyinghail@msn.com>
 */
trait ArrayTrait
{
	public function __isset(string $name)
	{
		return $this->has($name);
	}

	public function __set($name, $value)
	{
		$this->set($name, $value);
	}

	public function __get($name)
	{
		return $this->get($name);
	}

	public function __unset($name)
	{
		$this->delete($name);
	}

	public function offsetExists($offset)
	{
		return $this->has($offset);
	}

	public function offsetSet($offset, $value)
	{
		$this->set($offset, $value);
	}

	public function offsetGet($offset)
	{
		return $this->get($offset);
	}

	public function offsetUnset($offset)
	{
		$this->delete($offset);
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 */
	abstract public function set(string $key, $value);

	/**
	 * @param  string $key
	 *
	 * @return mixed
	 */
	abstract public function get(string $key);

	/**
	 * @param string $key
	 */
	abstract public function delete(string $key);

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key): bool
	{
		return $this->get($key) !== null;
	}

	/**
	 * @param array $array
	 */
	public function setMultiple(array $array): void
	{
		foreach ($array as $k => $v) {
			$this->set($k, $v);
		}
	}

	/**
	 * @param array $keys
	 *
	 * @return array
	 */
	public function getMultiple(array $keys): array
	{
		return \array_combine(
			$keys,
			\array_map([$this, 'get'], $keys)
		);
	}
}
