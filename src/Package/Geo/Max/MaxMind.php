<?php namespace Weboap\Visitor\Geo\Max;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

use Weboap\Visitor\Geo\Interfaces\GeoInterface;
use Illuminate\Config\Repository as Config;



class MaxMind implements GeoInterface{
    
    
    protected $reader;
    
    protected $config;
    
    public function __construct( Config $config )
    {
       $db = $config->get('visitor::maxmind_db_path');
       
       $this->reader = new Reader( $db );
    }
    
    
    function locate( $ip )
    {
        
        if( !$this->_validate($ip) )  return null;
        
        try{
           
            $record = $this->reader->city( $ip );
            
             return array(
                          'country_code'    =>      $record->country->isoCode,
                          'country_name'    =>      $record->country->name,
                          'state_code'      =>      $record->mostSpecificSubdivision->isoCode,
                          'state'           =>      $record->mostSpecificSubdivision->name,
                          'city'            =>      $record->city->name,
                          'postale_code'    =>      $record->postal->code
                           
                          );
        
        }
        catch (AddressNotFoundException $e) {
            
            return null;
        };
           
    }
    
    
    private function _validate( $ip )
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
    
    
 
    
  
    
}