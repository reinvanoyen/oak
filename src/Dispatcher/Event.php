<?php

namespace Oak\Dispatcher;

use Oak\Contracts\Dispatcher\EventInterface;

/**
 * Class Event
 * @package app\dispatcher
 */
class Event implements EventInterface
{
    /**
     * @var bool $propagationStopped
     */
    private $propagationStopped = false;

    /**
     * @return bool
     */
    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    /**
     * @return void
     */
    public function stopPropagation()
    {
        $this->propagationStopped = true;
    }
}