<?php namespace Weboap\Visitor\Services\Cache;



interface CacheInterface {

public function destroy( $key );

public function rememberForever( $key, $data );      


}