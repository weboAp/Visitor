<?php

namespace Weboap\Visitor\Services\Cache;

/**
 * Interface CacheInterface.
 */
interface CacheInterface
{
    /**
     * @param $key
     *
     * @return mixed
     */
    public function destroy($key);

    /**
     * @param $key
     * @param $data
     *
     * @return mixed
     */
    public function rememberForever($key, $data);
}
