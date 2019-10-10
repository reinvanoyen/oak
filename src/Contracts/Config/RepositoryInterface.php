<?php

namespace Oak\Contracts\Config;

interface RepositoryInterface
{
    /**
     * RepositoryInterface constructor.
     * @param array $config
     */
    public function __construct(array $config = []);

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function set(string $key, $value);

    /**
     * @return array
     */
    public function all(): array;
}