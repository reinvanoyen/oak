<?php

namespace Oak\Config;

use Oak\Contracts\Config\RepositoryInterface;

class Repository implements RepositoryInterface
{
    /**
     * @var array $config
     */
    private $config;

    /**
     * Repository constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
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
        return $this->config;
    }
}