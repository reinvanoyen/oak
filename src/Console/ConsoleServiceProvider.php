<?php

namespace Oak\Console;

use Oak\Console\Input\ConsoleInput;
use Oak\Console\Output\ConsoleOutput;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\ServiceProvider;

/**
 * Class ConsoleServiceProvider
 * @package Oak\Console
 */
class ConsoleServiceProvider extends ServiceProvider
{
    public function boot(ContainerInterface $app)
    {
        //
    }

    public function register(ContainerInterface $app)
    {
        // Set the console kernel
        $app->instance(ContainerInterface::class, $app);
        $app->singleton(KernelInterface::class, Kernel::class);
        $app->set(InputInterface::class, ConsoleInput::class);
        $app->set(OutputInterface::class, ConsoleOutput::class);
    }
}