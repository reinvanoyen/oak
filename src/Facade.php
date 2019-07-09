<?php

namespace Oak;

use Oak\Contracts\Container\ContainerInterface;

abstract class Facade
{
	/**
	 * The container from which to resolve the instances
	 *
	 * @var ContainerInterface $container
	 */
	private static $container;

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

		return self::$container->get(static::getContract());
	}

	public static function __callStatic($method, $arguments)
	{
		return static::getInstance()->$method(...$arguments);
	}
}