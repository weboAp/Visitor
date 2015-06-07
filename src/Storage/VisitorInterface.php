<?php namespace Weboap\Visitor\Storage;



interface VisitorInterface {

public function create( array $data);
      
public function get($ip);
      
public function update( $ip, array $data);     
      
public function delete( $ip );
   
public function all();
    
public function count( $ip );
   
public function increment( $ip );

public function clicksSum();

public function range( $start, $end);

}
