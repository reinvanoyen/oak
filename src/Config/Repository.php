<?php

namespace Oak\Config;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;

class Repository implements RepositoryInterface
{
    /**
     * @var bool $isLoaded
     */
    private $isLoaded = false;

    /**
     * @var FilesystemInterface $filesystem
     */
    private $filesystem;

    /**
     * @var string $cacheFile
     */
    private $cachePath;

    /**
     * @var string $configPath
     */
    private $configPath;

    /**
     * @var string $envPath
     */
    private $envPath;
    
    /**
     * @var array $config
     */
    private $config = [];

    /**
     * Repository constructor.
     * @param FilesystemInterface $filesystem
     * @param string $cacheFile
     */
    public function __construct(FilesystemInterface $filesystem, string $configPath, string $cachePath, string $envPath)
    {
        $this->filesystem = $filesystem;
        $this->configPath = $configPath;
        $this->cachePath = $cachePath;
        $this->envPath = $envPath;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        if (! $this->isLoaded) {
            $this->load();
        }
        
        $arr = explode('.', $key);
        $config = $this->config[$arr[0]] ?? $default;
        array_shift($arr);

        foreach ($arr as $keyPart) {
            if (! isset($config[$keyPart])) {
                return $default;
            }
            $config = $config[$keyPart];
        }

        return $config;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        if (! $this->isLoaded) {
            $this->load();
        }

        return isset($this->config[$key]);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        if (! $this->isLoaded) {
            $this->load();
        }

        return $this->config;
    }

    /**
     * Reload the config from the config files
     */
    public function reload()
    {
        // Load all variables from all config files to the repository
        foreach ($this->filesystem->files($this->configPath) as $file) {
            $this->set(str_replace('.php', '', basename($file)), require $file);
        }

        $this->set('app', [
            'env_path' => $this->envPath,
            'config_path' => $this->configPath,
            'cache_path' => $this->cachePath,
        ]);
        
        $this->isLoaded = true;
    }

    /**
     * Load the config while also checking for a cache file
     */
    private function load()
    {
        // Check if the cache file exists
        if ($this->filesystem->exists($this->cachePath.'config.php')) {
            // It exists so we set all config variables from the cache
            $this->config = require $this->cachePath.'config.php';
            $this->isLoaded = true;
            return;
        }
        
        $this->reload();
    }
}