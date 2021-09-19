<?php

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Class Service
 * @package App\Services
 */
abstract class Service
{
    /**
     * Prefix for call static magic method.
     */
    const PREFIX_METHOD = 'do';

    /**
     * @var static Singleton for all services.
     */
    protected static $instances = [];

    /**
     * Method initialization.
     *
     * @return static
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function init()
    {
        $serviceName = static::class;

        if (! isset(self::$instances[$serviceName])) {
            self::$instances[$serviceName] = app()->make(static::class);
        }

        return self::$instances[$serviceName];
    }

    /**
     * Alias of method init.
     *
     * @return static
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function on()
    {
        return static::init();
    }

    /**
     * Magic method.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws \BadMethodCallException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function __callStatic($name, $arguments)
    {
        static::init();

        $serviceName = static::class;

        $instance = self::$instances[$serviceName];

        if (Str::startsWith($name, static::PREFIX_METHOD)) {
            $method = substr($name, strlen(static::PREFIX_METHOD));

            $method = lcfirst($method);

            if (method_exists($instance, $method)) {
                return call_user_func_array([$instance, $method], $arguments);
            }
        }

        throw new \BadMethodCallException('Method '. $name .' not exists in class '. static::class .'.');
    }
}
