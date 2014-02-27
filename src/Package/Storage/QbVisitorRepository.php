<?php namespace Weboap\Visitor\Storage;

use Illuminate\Cache\CacheManager as Cache;
use Illuminate\Config\Repository as Config;

use Illuminate\Support\Facades\DB;
use DateTime;

class QbVisitorRepository implements Interfaces\VisitorInterface{

protected $tableName = null;

public function __construct(Config $config)
{
    
    $this->tableName = $config->get('visitor::table');
}


public function create( array $data)
{
    return DB::table( $this->tableName )->insert($data);
    
}

public function get($ip)
{
    return DB::table( $this->tableName )->whereIp( $ip )->first();
}
  
public function update( $ip, array $data)
{
    return DB::table( $this->tableName )->whereIp( $ip )->update( $data );
}    
       
public function delete( $ip )
{
    return DB::table( $this->tableName )->whereIp( $ip )->delete();   
    
}

public function all()
{
    // Query the database and cache it forever
   return DB::table( $this->tableName )->rememberForever( $this->tableName );
    
}



public function count( $ip = null )
{
    if( ! isset( $ip ) )
    {
        return DB::table( $this->tableName )->count();
    }
    else
    {
          return DB::table( $this->tableName )->whereIp( $ip )->count();  
    }
}


public function increment( $ip )
{
    DB::table( $this->tableName )->whereIp( $ip )->increment('clicks');
}

public function clicksSum()
{
    return DB::table( $this->tableName )->sum('clicks');
  
}

public function range($start, $end)
{
    return DB::table( $this->tableName )->whereBetween('created_at', array($start, $end))->count(); 
}



}