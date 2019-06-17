<?php

namespace Oak;

use Oak\Contracts\Container\ContainerInterface;

/**
 * Class ServiceProvider
 * @package Oak
 */
abstract class ServiceProvider
{
	/**
	 * @var bool $isLazy
	 */
	protected $isLazy = false;

	/**
	 * @var bool $booted
	 */
	private $booted = false;

	/**
	 * @return bool
	 */
	final public function isLazy(): bool
	{
		return $this->isLazy;
	}

	/**
	 * @return bool
	 */
	final public function isBooted(): bool
	{
		return $this->booted;
	}

	/**
	 *
	 */
	final public function setBooted()
	{
		$this->booted = true;
	}

	/**
	 * @param ContainerInterface $app
	 * @return mixed
	 */
	abstract public function boot(ContainerInterface $app);

	/**
	 * @param ContainerInterface $app
	 * @return mixed
	 */
	abstract public function register(ContainerInterface $app);

	/**
	 * @return array
	 */
	public function provides(): array
	{
		return [];
	}
}