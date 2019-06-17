<?php

namespace Oak\Contracts\Dispatcher;

/**
 * Interface DispatcherInterface
 * @package Hector\Contracts\Dispatcher
 */
interface DispatcherInterface
{
	/**
	 * @param string $eventName
	 * @param callable $listener
	 * @return mixed
	 */
	public function addListener(string $eventName, callable $listener);

	/**
	 * @param string $eventName
	 * @return array
	 */
	public function getListeners(string $eventName): array;

	/**
	 * @param string $eventName
	 * @return bool
	 */
	public function hasListeners(string $eventName): bool;

	/**
	 * @param string $eventName
	 * @param EventInterface|null $event
	 * @return mixed
	 */
	public function dispatch(string $eventName, EventInterface $event = null);
}