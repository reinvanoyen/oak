<?php

namespace Oak\Migration;

use Oak\Config\Facade\Config;
use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Migration\Console\MigrationCommand;
use Oak\Migration\Logger\ConsoleMigrationLogger;
use Oak\Migration\Storage\JsonVersionStorage;
use Oak\ServiceProvider;
use Oak\Migration\Console\Migrator\Command;
use Oak\Contracts\Migration\MigrationLoggerInterface;
use Oak\Contracts\Migration\VersionStorageInterface;

class MigrationServiceProvider extends ServiceProvider
{
    public function register(ContainerInterface $app)
    {
        if ($app->isRunningInConsole()) {

            $app->set(MigrationCommand::class, MigrationCommand::class);

            $app->singleton(MigrationManager::class, MigrationManager::class);
            $app->set(Migrator::class, Migrator::class);
            $app->set(Command::class, Command::class);
            $app->set(MigrationLoggerInterface::class, ConsoleMigrationLogger::class);
            $app->set(VersionStorageInterface::class, function() use ($app) {
                return $app->getWith(JsonVersionStorage::class, [
                    'filename' => Config::get('migration.version_filename'),
                ]);
            });
        }
    }

    public function boot(ContainerInterface $app)
    {
        if ($app->isRunningInConsole()) {

            $console = $app->get(KernelInterface::class);
            $console->registerCommand(MigrationCommand::class);
        }
    }
}