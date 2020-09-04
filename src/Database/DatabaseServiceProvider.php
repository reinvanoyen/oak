<?php

namespace Oak\Database;

use Oak\Contracts\Container\ContainerInterface;
use Oak\ServiceProvider;
use Oak\Contracts\Database\ConnectionManagerInterface;
use Oak\Database\QueryBuilder\Compiler\Compiler;
use Oak\Contracts\Database\QueryBuilder\Compiler\CompilerInterface;

/**
 * Service provider for providing the database component to the framework.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class DatabaseServiceProvider extends ServiceProvider
{
    public function register(ContainerInterface $app)
    {
        // Core & Connections
        $app->set(ConnectionManagerInterface::class, ConnectionManager::class);
        
        // QueryBuilder
        $app->set(CompilerInterface::class, Compiler::class);
    }

    public function boot(ContainerInterface $app)
    {
        //
    }
}