<?php

namespace Volcano\Cache;

use Exception;
use Volcano\Cache\Adapter\AdapterInterface;
use Volcano\Cache\Adapter\RedisAdapter;

final class Cache
{
    private const REDIS_ADAPTER = 'redis';

    /** @var AdapterInterface $adapter */
    private AdapterInterface $adapter;

    /**
     * @param array $options
     * @return AdapterInterface
     * @throws Exception
     */
    public static function factory(array $options): AdapterInterface
    {
        return match ($options['adapter']) {
            self::REDIS_ADAPTER => new RedisAdapter($options),
            default => throw new Exception("")
        };
    }

}
