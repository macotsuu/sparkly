<?php

namespace Volcano\Cache;

use Exception;

class CacheFactory
{
    /** @var array<CacheFactory> */
    private static array $instances = [];

    protected function __construct()
    {
    }

    public static function cache(): CacheFactory
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }
        return self::$instances[$subclass];
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot serialize singleton");
    }

    protected function __clone()
    {
    }
}
