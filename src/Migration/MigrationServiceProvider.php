<?php

namespace Oak\Migration;

use Oak\Config\Facade\Config;
use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Migration\Console\MigrationCommand;
use Oak\Migration\Logger\ConsoleMigrationLogger;
use Oak\Migration\Storage\FileVersionStorage;
use Oak\Migration\Storage\JsonVersionStorage;
use Oak\ServiceProvider;
use Oak\Contracts\Migration\MigrationLoggerInterface;
use Oak\Contracts\Migration\VersionStorageInterface;

/**
 * Service provider for the migration component.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class MigrationServiceProvider extends ServiceProvider
{
    public function register(ContainerInterface $app)
    {
        if ($app->isRunningInConsole()) {
            
            $config = $app->get(RepositoryInterface::class);
            
            $app->set(MigrationCommand::class, MigrationCommand::class);

            $app->singleton(MigrationManager::class, MigrationManager::class);
            $app->set(Migrator::class, Migrator::class);
            $app->set(MigrationLoggerInterface::class, ConsoleMigrationLogger::class);
            
            $app->set(VersionStorageInterface::class, $config->get('migration.version_storage', JsonVersionStorage::class));
            
            $app->whenAsksGive(
                JsonVersionStorage::class,
                'filename',
                $config->get('migration.version_path', 'permanent/migration').'/'.$config->get('migration.version_filename', 'versions.json')
            );
            
            $app->whenAsksGive(
                FileVersionStorage::class,
                'path',
                $config->get('migration.version_path', 'permanent/migration')
            );
        }
    }

    public function boot(ContainerInterface $app)
    {
        if ($app->isRunningInConsole()) {
            $app->get(KernelInterface::class)
                ->registerCommand(MigrationCommand::class)
            ;
        }
    }
}