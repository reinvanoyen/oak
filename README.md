<img src="https://raw.githubusercontent.com/reinvanoyen/oak/master/oak-logo.png" />

### Simple PHP building blocks framework

* [Config](#config)
* [Console](#console)
* [Container](#container)
* [Dispatcher](#dispatcher)
* [Filesystem](#filesystem)
* [Logger](#logger)
* [Session](#session)

#### Config

Documentation coming soon

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

#### Dispatcher

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
filename | cache/logs/log.txt
date_format | d/m/Y H:i

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
path | cache/sessions
name | oak_app
cookie_prefix | session
identifier_length | 40