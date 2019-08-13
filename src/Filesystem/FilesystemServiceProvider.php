<?php

namespace Oak\Filesystem;

use Oak\Console\Facade\Console;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Filesystem\Console\Filesystem;
use Oak\ServiceProvider;

/**
 * Class FilesystemServiceProvider
 * @package Oak\Filesystem
 */
class FilesystemServiceProvider extends ServiceProvider
{
	public function boot(ContainerInterface $app)
	{
		Console::registerCommand(Filesystem::class);
	}

	public function register(ContainerInterface $app)
	{
		$app->set(FilesystemInterface::class, LocalFilesystem::class);

		// Console
		$app->set(Filesystem::class, Filesystem::class);
	}
}