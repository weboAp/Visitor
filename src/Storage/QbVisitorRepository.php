<?php namespace Weboap\Visitor\Storage;


use Illuminate\Config\Repository as Config;
use Illuminate\Database\DatabaseManager as DB;


class QbVisitorRepository implements VisitorInterface{


protected $tableName = null;

/**
 *  Illuminate\Database\DatabaseManager Instance
 * @var Illuminate\Database\DatabaseManager
 **/

protected $db;



/**
 *  Config Instance
 * @var Illuminate\Config\Repository
 **/

protected $config;





public function __construct(Config $config, DB $db)
{
    
    $this->config       = $config;
    $this->db           = $db;
}


public function setTable($table)
{
    $this->tableName = $table;
}

public function getTable()
{
    return isset( $this->tableName )? $this->tableName : $this->config->get('visitor.table');
    
}

public function create( array $data)
{
    return $this->db->table( $this->getTable() )->insert($data);
    
}

public function get($ip)
{
    return $this->db->table( $this->getTable() )->whereIp( $ip )->first();
}
  
public function update( $ip, array $data)
{
    return $this->db->table( $this->getTable() )->whereIp( $ip )->update( $data );
}    
       
public function delete( $ip )
{
    return $this->db->table( $this->getTable() )->whereIp( $ip )->delete();
   
}

public function all()
{
    return $this->db->table( $this->getTable() )->get();
    
}



public function count( $ip = null )
{
    if( ! isset( $ip ) )
    {
        return $this->db->table( $this->getTable() )->count();
    }
    else
    {
          return $this->db->table( $this->getTable() )->whereIp( $ip )->count();  
    }
}


public function increment( $ip )
{
    $this->db->table( $this->getTable() )->whereIp( $ip )->increment('clicks');
}

public function clicksSum()
{
    return $this->db->table( $this->getTable() )->sum('clicks');
  
}

public function range($start, $end)
{
    return $this->db->table( $this->getTable() )->whereBetween('created_at', array($start, $end))->count(); 
}

/**
 * delete all options from db.
 * @return void
 */
public function clear()
{
   $this->db->table( $this->getTable() )->truncate();
}



}