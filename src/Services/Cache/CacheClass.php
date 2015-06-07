<?php namespace Weboap\Visitor\Services\Cache;



use Illuminate\Cache\CacheManager as Cache;


class CacheClass implements CacheInterface {
    
    protected $cache;
    
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
        
    }


    
    
    public function destroy( $key )
    {
        $this->cache->forget( $key );
    }
    
    
    public function rememberForever( $key, $data )
    {
       
       return $this->cache->rememberForever( $key, function() use ( $data )
	                                {
	                                    return $data;
	                                });
    }
    
    
    
    
    
    
    
    
    
    
}