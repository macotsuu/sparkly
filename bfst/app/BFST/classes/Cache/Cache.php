<?php

namespace BFST\Cache;

use Redis;
use RedisException;

class Cache extends CacheFactory
{
    private Redis $redis;

    protected function __construct()
    {
        try {
            $this->redis = new Redis();
            $this->redis->connect(env('REDIS_HOST', 'localhost'), env('REDIS_PORT', 6379));
            $this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);

        } catch (RedisException $e) {

        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     * @throws RedisException
     */
    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        return $this->redis->setex($key, $ttl, $value);
    }

    /**
     * @param string $key
     * @return mixed
     * @throws RedisException
     */
    public function get(string $key): mixed
    {
        return $this->redis->get($key);
    }
}