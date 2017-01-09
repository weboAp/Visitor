<?php

namespace Weboap\Visitor\Services\Cache;

use Illuminate\Cache\CacheManager as Cache;

/**
 * Class CacheClass.
 */
class CacheClass implements CacheInterface
{
    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cache;

    /**
     * CacheClass constructor.
     *
     * @param \Illuminate\Cache\CacheManager $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param $key
     */
    public function destroy($key)
    {
        $this->cache->forget($key);
    }

    /**
     * @param $key
     * @param $data
     *
     * @return mixed
     */
    public function rememberForever($key, $data)
    {
        return $this->cache->rememberForever($key, function () use ($data) {
            return $data;
        });
    }
}
