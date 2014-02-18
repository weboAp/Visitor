<?php namespace Weboap\Visitor\Libs\Geo;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

use Exception;
use Illuminate\Config\Repository as Config;


class GeoLocation {
    
    
    protected $config;
    protected $reader;
    
    public function __construct( Config $config, Reader $reader )
    {
      $this->config = $config;
      $this->reader = $reader;
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

class DatabaseNotFoundException extends Exception {}