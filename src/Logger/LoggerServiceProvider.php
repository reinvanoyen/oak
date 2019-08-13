<?php

namespace Oak\Logger;

use Oak\Console\Facade\Console;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Contracts\Logger\LoggerInterface;
use Oak\Logger\Console\Logger;
use Oak\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider
{
	public function boot(ContainerInterface $app)
	{
		Console::registerCommand(Logger::class);
	}

	public function register(ContainerInterface $app)
	{
		$app->set(Logger::class, Logger::class);

		$app->set(LoggerInterface::class, function() use ($app) {
			return new FileLogger('cache/logs/log.txt', $app->get(FilesystemInterface::class));
		});
	}
}