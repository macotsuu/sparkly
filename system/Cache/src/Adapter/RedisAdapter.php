<?php

namespace Volcano\Cache\Adapter;

use Exception;
use Redis;
use RedisException;

class RedisAdapter implements AdapterInterface
{
    /** @var Redis $redis */
    private Redis $redis;

    /**
     * @param array $options
     * @throws Exception
     */
    public function __construct(array $options)
    {
        try {
            $this->redis = new Redis();
            $this->redis->connect(
                $options['host'],
                $options['port']
            );
            $this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
        } catch (RedisException $ex) {
            throw new Exception("Failed to initialise Redis " . $ex->getMessage());
        }
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