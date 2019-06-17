<?php

namespace Oak\Contracts\Dispatcher;

/**
 * Interface EventInterface
 * @package Hector\Contracts\Dispatcher
 */
interface EventInterface
{
	/**
	 * @return bool
	 */
	public function isPropagationStopped(): bool;

	/**
	 * @return mixed
	 */
	public function stopPropagation();
}