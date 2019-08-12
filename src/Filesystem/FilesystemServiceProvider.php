<?php

namespace Oak\Filesystem;

use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\ServiceProvider;

/**
 * Class FilesystemServiceProvider
 * @package Oak\Filesystem
 */
class FilesystemServiceProvider extends ServiceProvider
{
	protected $isLazy = true;

	public function boot(ContainerInterface $app)
	{
		//
	}

	public function register(ContainerInterface $app)
	{
		$app->set(FilesystemInterface::class, LocalFilesystem::class);
	}

	public function provides(): array
	{
		return [FilesystemInterface::class,];
	}
}