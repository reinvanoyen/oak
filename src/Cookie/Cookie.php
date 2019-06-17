<?php

namespace Oak\Cookie;

use Oak\Contracts\Cookie\CookieInterface;

class Cookie implements CookieInterface
{
	/**
	 * @var string $path
	 */
	private $path;

	/**
	 * Cookie constructor.
	 * @param string $path
	 */
	public function __construct(string $path)
	{
		$this->path = $path;
	}

	/**
	 * @param string $name
	 * @param $value
	 * @param int $expire
	 * @return mixed|void
	 */
	public function set(string $name, $value, int $expire = 0)
	{
		$value = json_encode($value);
		setcookie($name, $value, $expire, $this->path);
		$_COOKIE[$name] = $value;
	}

	/**
	 * @param string $name
	 * @return mixed|null
	 */
	public function get(string $name)
	{
		if ($this->has($name)) {
			return json_decode($_COOKIE[$name]);
		}

		return null;
	}

	/**
	 * @param $name
	 * @return bool
	 */
	public function has(string $name): bool
	{
		return (isset($_COOKIE[$name]));
	}
}