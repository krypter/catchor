<?php namespace Krypter\Catchor;

use Illuminate\Support\ServiceProvider;
use Config;

class CatchorServiceProvider extends ServiceProvider
{

    /**
    * Register the service provider.
    *
    * @return void
    */
    public function register()
    {
        $this->package('krypter/catchor');
        foreach (Config::get('catchor::config.catchers') as $catcher)
        {
            (new $catcher())->register();   
        }
        foreach (Config::get('catchor::config.raw_files') as $file)
        {
            include_once $file;   
        }
    }

}