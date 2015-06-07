<?php namespace Weboap\Visitor\Services\Geo;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request as Request;
use Weboap\Visitor\Ip;


class MaxMind implements GeoInterface{
    
    
    protected $reader;
    
    protected $config;
    
    protected $ip;
    
    public function __construct( Config $config, Ip $ip )
    {
       $this->config = $config; 
       $this->ip = $ip;
    }
    

    
    public function locate()
    {
        //
        $ip = $this->ip->get();
        $db =  $this->config->get('visitor.maxmind_db_path');
        
        if( !is_string($db) || ! file_exists( $db )|| ! $this->ip->isValid( $ip ) ) return [];
        
        
        $this->reader = new Reader( $db );
         
        try{
           
            $record = $this->reader->city( $ip );
            
             return [
                          'country_code'    =>      $record->country->isoCode,
                          'country_name'    =>      $record->country->name,
                          'state_code'      =>      $record->mostSpecificSubdivision->isoCode,
                          'state'           =>      $record->mostSpecificSubdivision->name,
                          'city'            =>      $record->city->name,
                          'postale_code'    =>      $record->postal->code
                           
                    ];
        
        }
        catch (AddressNotFoundException $e) {
            
            return [];
        };
           
    }
    
    

    
  
    
}

