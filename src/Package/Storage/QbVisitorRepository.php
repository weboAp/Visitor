<?php namespace Weboap\Visitor\Storage;

use Config;
use Illuminate\Support\Facades\DB;

class QbVisitorRepository implements VisitorInterface{

protected $tableName = null;

public function __construct()
{
    $this->tableName = 'visitor_registry';
}

public function all()
{
    // Query the database and cache it forever
   return DB::table( $this->tableName )->rememberForever( $this->tableName );
    
}
   
public function increment($key, array $data)
{
    return DB::table( $this->tableName )->where('key', $key)->update($data);
}    
    

public function create( array $data)
{
    return DB::table( $this->tableName )->insert($data);
    
}
    
public function delete($key)
{
    return DB::table( $this->tableName )->where('key', '=', $key)->delete();   
    
}


}