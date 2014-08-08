<?php namespace Krypter\Catchor;

use App, ReflectionClass, ReflectionMethod;

abstract class ExceptionCatcher {

    /**
     * Register catch fonctions
     *
     * @var boolean
     */
    public $catch = true;

    /**
     * Register raw fonction
     *
     * @var boolean
     */
    public $raw = false;

    /**
     * Find catch methode and build them
     *
     * @return void
     */
    public function register()
    {
        if($this->catch) $this->bind();
        if($this->raw) $this->raw();
    }

    /**
     * Build catch method
     *
     * @return void
     */
    public function bind()
    {
        foreach ($this->getMethods() as $method) if(str_contains($method->name, 'catch')) $this->build($method);
    }

    /**
     * Add method to error
     * 
     * @param  ReflectionMethod $method 
     * @return void
     */
    protected function build(ReflectionMethod $method)
    {
        App::error(function($e, $code, $fromConsole) use ($method) {
            if(get_class($e) == $this->getExceptionClassName($method)) return $this->{$method->name}($e, $code, $fromConsole);
        });
    }

    /**
     * Get methods all methods including subclass methods
     * 
     * @return array
     */
    protected function getMethods()
    {
        return (new ReflectionClass(get_class($this)))->getMethods();
    }

    /**
     * Get first parameter of subclass method
     * 
     * @param  ReflectionMethod $method
     * @return Exception
     */
    protected function getException(ReflectionMethod $method)
    {
        return $method->getParameters()[0];
    }

    /**
     * Get exception class name
     * 
     * @param  ReflectionMethod $method 
     * @return string                   
     */
    protected function getExceptionClassName(ReflectionMethod $method)
    {
        return $this->getException($method)->getClass()->name;
    }

}