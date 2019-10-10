<?php

namespace Oak\Dispatcher;

use Oak\Contracts\Dispatcher\DispatcherInterface;
use Oak\Contracts\Dispatcher\EventInterface;

/**
 * Class Dispatcher
 * @package Oak\Dispatcher
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var array $listeners
     */
    private $listeners = [];

    /**
     * Add a listener to an event by name
     *
     * @param string $eventName
     * @param callable $listener
     */
    public function addListener(string $eventName, callable $listener)
    {
        if (! $this->hasListeners($eventName)) {
            $this->listeners[$eventName] = [];
        }

        $this->listeners[$eventName][] = $listener;
    }

    /**
     * Gets the listeners of an event by name
     *
     * @param string $eventName
     * @return array
     */
    public function getListeners(string $eventName): array
    {
        return $this->listeners[$eventName] ?? [];
    }

    /**
     * Checks if there are listeners for event by name
     *
     * @param string $eventName
     * @return bool
     */
    public function hasListeners(string $eventName): bool
    {
        return (bool) count($this->getListeners($eventName));
    }

    /**
     * Dispatches an event by name
     *
     * @param string $eventName
     * @param Event|null $event
     */
    public function dispatch(string $eventName, EventInterface $event = null)
    {
        // Check if there are listeners for this event
        if (! $this->hasListeners($eventName)) {
            return;
        }

        // Call every listener for this event
        foreach ($this->getListeners($eventName) as $listener) {
            $listener($event);

            // Stop calling the listeners if the propagation was stopped
            if ($event->isPropagationStopped()) {
                break;
            }
        }
    }
}