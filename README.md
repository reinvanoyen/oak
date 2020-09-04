<img src="https://raw.githubusercontent.com/reinvanoyen/oak/master/oak-logo.png" />

### Simple PHP building blocks framework

* [Config](#config)
* [Console](#console)
* [Container](#container)
* [Dispatcher](#dispatcher)
* [Database](#database)
* [Filesystem](#filesystem)
* [Logger](#logger)
* [Scheduler](#scheduler)
* [Session](#session)
* [Migration](#migration)

#### Install
```ssh
composer require reinvanoyen/oak
```

#### Creating an application

```php
<?php

$app = new \Oak\Application(
    __DIR__.'/../', // The path to your .env file
    __DIR__.'/../config/', // The path to your config files
    __DIR__.'/../cache/' // The path where the application can write cache to 
);

$app->register([
    \Oak\Console\ConsoleServiceProvider::class,
]);

$app->bootstrap();
```

The example above only registers the Console component. This is an easy example since the Console component doesn't 
depend on any other components. To run the Console component, you'll have to get the Console\Kernel from your 
application handle the incoming Input:

```php
<?php

use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Console\KernelInterface;

$app->get(KernelInterface::class)->handle(
    $app->get(InputInterface::class),
    $app->get(OutputInterface::class)
);
```

To use the HTTP component (PSR-7 & PSR-15 compliant) you'll also have to register the Config component...and since the Config component reads 
configuration values from the filesystem, you'll also have to register the Filesystem component:

```php
<?php

$app->register([
    \Oak\Console\ConsoleServiceProvider::class,
    \Oak\Http\HttpServiceProvider::class,
    \Oak\Config\ConfigServiceProvider::class,
    \Oak\Filesystem\FilesystemServiceProvider::class,
]);
```

Handling an incoming request with the Http\Kernel goes as follows:

```php
<?php

use Oak\Contracts\Http\KernelInterface;
use Psr\Http\Message\ServerRequestInterface;

$app->get(KernelInterface::class)->handle(
    $app->get(ServerRequestInterface::class)
);
```

#### Config

```php
<?php

use Oak\Config\Facade\Config;

Config::set('package', [
  'client_id' => '123',
  'client_secret' => 'F1jK4s5mPs9s1_sd1wpalnbs5H1',
]);

echo Config::get('package.client_secret'); // F1jK4s5mPs9s1_sd1wpalnbs5H1
```

##### Config commands

Remove the config cache file:
```ssh
php oak config clear-cache
```
Cache the config (also reloads the config and thus overwrites any existing cache):
```ssh
php oak config cache
```

#### Console

Documentation coming soon

#### Container

Documentation coming soon

#### Cookie

##### Example usage

```php
<?php

use Oak\Cookie\Facade\Cookie;

Cookie::set('key', 'value');

echo Cookie::get('key'); // value
```

##### Cookie config options

Name | Default
---- | -------
path | /
secure | false
http_only | true

#### Dispatcher

```php
<?php

use Oak\Dispatcher\Facade\Dispatcher;

Dispatcher::addListener('created', function($event) {
  echo 'Creation happened!';
});

Dispatcher::dispatch('created', new Event());
```

#### Database

Documentation coming soon

#### Filesystem

Documentation coming soon

#### Logger

##### Example usage

```php
<?php

use Oak\Logger\Facade\Logger;

Logger::log('This message will be logged');
```

##### Logger config options

Name | Default
---- | -------
filename | logs/log.txt
date_format | d/m/Y H:i

#### Scheduler

Documentation coming soon

#### Session

##### Example usage

```php
<?php

use Oak\Session\Facade\Session;

Session::set('key', 'value');
Session::save();

echo Session::get('key'); // value
```

##### Session config options

Name | Default
---- | -------
handler | \Oak\Session\FileSessionHandler
path | sessions
name | app
cookie_prefix | session
identifier_length | 40
lottery | 200
max_lifetime | 1000

#### Migration

```php
<?php

use Oak\Migration\Migrator;
use Oak\Migration\MigrationManager;

// Create a migrator with name "app"
$migrator = $app->getWith(Migrator::class, ['name' => 'app',]);

// Set some revisions
$migrator->setRevisions([
    CreatePageTable::class,
    CreateSettingsTable::class,
]);

// Add the migrator to the migration manager
$app->get(MigrationManager::class)
    ->addMigrator($migrator);
```

##### Migration config options

Name | Default
---- | -------
version_storage | \Oak\Migration\Storage\JsonVersionStorage
version_filename | 'permanent/migration/versions.json'

##### Migration commands
Get an overview of the migration CLI:
```ssh
php oak migration
```
List all registered migrators:
```ssh
php oak migration list
```
Migrate to the latest version:
```ssh
php oak migration list
```
Migrate to the next version:
```ssh
php oak migration update
```
Migrate to the previous version:
```ssh
php oak migration downdate
```
Undo all migrations
```ssh
php oak migration reset
```