<?php

namespace Oak;

use Oak\Container\Container;

/**
 * Class Application
 * @package Oak
 */
class Application extends Container
{
    const VERSION = '1.0.7';

    /**
     * @var bool $isBooted
     */
    private $isBooted;

    /**
     * @var array $registeredProviders
     */
    private $registeredProviders = [];

    /**
     * @var array $lazyProviders
     */
    private $lazyProviders = [];

    /**
     * Application constructor.
     */
    public function __construct()
    {
        // We set this application as the container for the facade
        Facade::setContainer($this);
    }

    /**
     * @param $provider
     * @throws \Exception
     */
    public function register($provider): void
    {
        if (is_array($provider)) {
            foreach ($provider as $service) {
                $this->register($service);
            }
            return;
        }

        if (is_string($provider)) {
            $this->set($provider, $provider);
            $provider = $this->get($provider);
        }

        if ($provider->isLazy()) {
            foreach ($provider->provides() as $providing) {
                $this->lazyProviders[$providing] = $provider;
            }
            $provider->register($this);
        } else {
            $this->registeredProviders[] = $provider;
            $this->initServiceProvider($provider);
        }
    }

    /**
     * Initialize a service provider
     *
     * @param ServiceProvider $provider
     */
    private function initServiceProvider(ServiceProvider $provider): void
    {
        $provider->register($this);

        // If the application is already booted, boot the provider right away
        if ($this->isBooted) {
            $this->bootServiceProvider($provider);
        }
    }

    /**
     * @param ServiceProvider $provider
     */
    private function bootServiceProvider(ServiceProvider $provider)
    {
        if (! $provider->isBooted()) {
            $provider->setBooted();
            $provider->boot($this);
        }
    }

    /**
     * Get a value by key from the container making sure lazy providers are initialized first
     *
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (isset($this->lazyProviders[$key])) {
            $this->bootServiceProvider($this->lazyProviders[$key]);
            unset($this->lazyProviders[$key]);
        }

        return parent::get($key);
    }

    /**
     * Boots all non-lazy registered service providers
     *
     * @return void
     */
    private function boot(): void
    {
        // First check if the application is already booted
        if ($this->isBooted) {
            return;
        }

        // Boot all registered providers
        foreach ($this->registeredProviders as $provider) {
            $this->bootServiceProvider($provider);
        }

        $this->isBooted = true;
    }

    /**
     * Bootstrap the application
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // We boot all service providers
        $this->boot();
    }

    /**
     * @return bool
     */
    public function isRunningInConsole(): bool
    {
        return php_sapi_name() === 'cli';
    }
}