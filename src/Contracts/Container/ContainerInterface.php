<?php

namespace Oak\Contracts\Container;

/**
 * Interface ContainerInterface
 * @package Oak\Contracts\Container
 */
interface ContainerInterface
{
	/**
	 * @param string $contract
	 * @param $mixed
	 * @return mixed
	 */
	public function set(string $contract, $mixed);

	/**
	 * @param string $contract
	 * @return mixed
	 */
	public function get(string $contract);

	/**
	 * @param string $contract
	 * @return bool
	 */
	public function has(string $contract): bool;
}