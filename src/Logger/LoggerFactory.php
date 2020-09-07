<?php

namespace Oak\Logger;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Logger\LoggerInterface;

class LoggerFactory
{
    /**
     * @var ContainerInterface $app
     */
    private $app;

    /**
     * @var RepositoryInterface $config
     */
    private $config;
    
    /**
     * LoggerFactory constructor.
     * @param ContainerInterface $app
     * @param RepositoryInterface $config
     */
    public function __construct(ContainerInterface $app, RepositoryInterface $config)
    {
        $this->app = $app;
        $this->config = $config;
    }
    
    /**
     * @param string $name
     * @return LoggerInterface
     */
    public function make(string $name = 'default'): LoggerInterface
    {
        $config = $this->config->get('logger.channels.'.$name);
        $configClass = $config['class'];

        // Make the logger
        return $this->app->getWith($configClass, $config);
    }
}