<?php

namespace Oak\Logger;

use Oak\Contracts\Logger\LoggerInterface;

class ChannelManager
{
    /**
     * @var array $channels
     */
    private $channels = [];

    /**
     * @var LoggerFactory $loggerFactory
     */
    private $loggerFactory;

    /**
     * ChannelManager constructor.
     * @param LoggerFactory $loggerFactory
     */
    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->loggerFactory = $loggerFactory;
    }

    /**
     * @param string $name
     * @return LoggerInterface
     */
    public function channel(string $name = 'default'): LoggerInterface
    {
        if (isset($this->channels[$name])) {
            return $this->channels[$name];
        }
        
        // Store the logger
        $this->channels[$name] = $logger = $this->loggerFactory->make($name);
        
        return $logger;
    }
}