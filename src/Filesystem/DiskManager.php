<?php

namespace Oak\Filesystem;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;

class DiskManager
{
    /**
     * @var array $disks
     */
    private $disks = [];

    /**
     * @var ContainerInterface $app
     */
    private $app;
    
    /**
     * @var RepositoryInterface $config
     */
    private $config;

    /**
     * DiskManager constructor.
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
     * @return FilesystemInterface
     */
    public function disk(string $name = 'default'): FilesystemInterface
    {
        if (isset($this->disks[$name])) {
            return $this->disks[$name];
        }
        
        $diskConfig = $this->config->get('filesystem.disks.'.$name);
        
        $diskClass = $diskConfig['class'];
        
        // Get the filesystem from the container
        $filesystem = $this->app->get($diskClass);
        $this->disks[$name] = $filesystem;
        
        return $filesystem;
    }
}