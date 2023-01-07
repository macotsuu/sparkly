<?php

namespace Volcano\Cache;

use Redis;
use RedisException;

final class Cache extends CacheFactory
{
    private Redis $redis;

    protected function __construct()
    {
        try {
            $this->redis = new Redis();
            $this->redis->connect(
                env('REDIS_HOST', 'localhost'),
                env('REDIS_PORT', '6379')
            );
            $this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
        } catch (RedisException $e) {
            echo $e->getMessage();
        }

        parent::__construct();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     */
    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        try {
            return $this->redis->setex($key, $ttl, $value);
        } catch (RedisException) {
            return false;
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        try {
            return $this->redis->get($key);
        } catch (RedisException) {
            return false;
        }
    }
}
