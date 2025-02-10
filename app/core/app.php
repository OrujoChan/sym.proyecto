<?php

namespace dwes\app\core;

use dwes\app\database\QueryBuilder;
use dwes\app\exceptions\AppException;
use dwes\app\database\Connection;

class App
{
    /**
     * @var array
     */
    private static $container = [];
    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public static function bind(string $key, $value)
    {
        static::$container[$key] = $value;
    }
    /**
     * @param string $key
     * @throws AppException
     */
    public static function get(string $key)
    {
        if (!array_key_exists($key, static::$container))
            throw new AppException("No se ha encontrado la clave $key en el contenedor");
        return static::$container[$key];
    }

    public static function getConnection()
    {
        if (!array_key_exists('connection', static::$container))
            static::$container['connection'] = Connection::make();
        return static::$container['connection'];
    }

    public static function getRepository(string $className): QueryBuilder
    {
        if (!array_key_exists($className, static::$container))
            static::$container[$className] = new $className();

        return static::$container[$className];
    }
}
