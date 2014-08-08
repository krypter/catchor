# Laravel Catchor

This package gives you an easy way to manage exceptions.

## Installation

Install Catchor through Composer.

```js
"require": {
    "krypter/catchor": "0.2"
}
```

Update `app/config/app.php` to include a reference to this package's service provider in the providers array.

```php
'providers' => [
    'Krypter\Catchor\CatchorServiceProvider'
]
```

Publish the config file from the command line. *(optional)*
The config file will be publish here `app/config/packages/krypter/catchor/config.php`.

```bash
php artisan config:publish krypter/catchor
```

## Usage

### With a simple file

By default Catchor looking for `app/exceptions/catchers.php`. You need to create the `exceptions` directory inside the `app` directory and create a file named `catchers.php` inside the `exceptions` directory. 

Finaly, write the code you want in it.

```php
<?php 

// Example
App::error(function(Exception $e)
{
    Log::error($e);
});

```

You can change the path of this file and/or add other files if you want it to. You must publish the config and modify the `raw_files` array.

```php
'raw_files' => [
    app_path() . '/exceptions/catchers.php',  // By default
    '/path/to/your/file.php' // Your path
]
```

You're done!

### With a class

First, create a class. It must extends `Krypter\Catchor\ExceptionCatcher`

```php
<?php namespace Acme\Exception;

use Krypter\Catchor\ExceptionCatcher;

class Catcher extends ExceptionCatcher {

    // We will catch exception from here

}
```

Next, add functions starting with `catch` 

```php
// Template
public function catchException(\Exception $e, $code, $fromConsole)
{
    return 'Do what you wanna do!';
}

// Real world example
public function catchNotFoundHttpException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $code, $fromConsole)
{
    return \View::make('pages.404');
}
```

You can also use `raw()` method and write what you want in it. To enable this option you need to add `public $raw = true;`

```php

public $raw = true;

public function raw()
{
    // Example
    App::error(function(Exception $e)
    {
        Log::error($e);
    });
}
```

If you don't have method starting with `catch` you need to disable this option by adding `public $catch = false`.

Finally, you must have publish the config, empty the `raw_files` array *(unless you use it)* and modify the `catchers` array to add this class in the config file. *(You can add multiple catcher)*

```php
'catchers' => [
    'Acme\Exception\Catcher'
],
'raw_files' => []
```

You're done!


## MIT License

[View the license](https://github.com/krypter/catchor/blob/master/LICENSE) for this repo.

## Contact

Follow [@krypter_io](http://twitter.com/krypter_io) on Twitter for the latest news.

