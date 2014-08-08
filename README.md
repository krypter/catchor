# Laravel Catchor

This package gives you an easy way to manage exceptions.

## Installation

Install Catchor through Composer.

```js
"require": {
    "krypter/catchor": "0.1"
}
```

Next, update `app/config/app.php` to include a reference to this package's service provider in the providers array.

```php
'providers' => [
    'Krypter\Catchor\CatchorServiceProvider'
]
```

Finaly, publish the config file from the command line.

```bash
php artisan config:publish krypter/catchor
```

## Usage

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

Finally, add this class in the config file `app/config/packages/krypter/catchor/config.php` (You can add multiple catcher)

```php
return [
    'catchers' => [
        'Acme\Exception\Catcher'
    ]
];
```

You're done!


## MIT License

[View the license](https://github.com/krypter/catchor/blob/master/LICENSE) for this repo.

