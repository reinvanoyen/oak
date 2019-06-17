<?php

namespace Oak\Contracts\Cookie;

interface CookieInterface
{
	/**
	 * @param string $name
	 * @param $value
	 * @param int $expire
	 * @return mixed
	 */
	public function set(string $name, $value, int $expire = 0);

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function get(string $name);

	/**
	 * @param string $name
	 * @return bool
	 */
	public function has(string $name): bool;
}