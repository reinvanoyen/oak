<?php

namespace Oak;

use Oak\Contracts\ContainerInterface;

abstract class Facade
{
	/**
	 * The container from which to resolve the instances
	 *
	 * @var ContainerInterface $container
	 */
	private static $container;

	/**
	 * The resolved instances
	 *
	 * @var $instance
	 */
	protected static $instances = [];

	/**
	 *
	 *
	 * @param ContainerInterface $container
	 */
	public static function setContainer(ContainerInterface $container)
	{
		self::$container = $container;
	}

	/**
	 * @return string
	 */
	abstract protected static function getContract(): string;

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	final private static function getInstance()
	{
		if (! self::$container) {
			throw new \Exception('No container set for facades');
		}

		$contract = static::getContract();

		if (! isset(static::$instances[$contract])) {
			static::$instances[$contract] = self::$container->get($contract);
		}

		return static::$instances[$contract];
	}

	public static function __callStatic($method, $arguments)
	{
		return static::getInstance()->$method(...$arguments);
	}
}