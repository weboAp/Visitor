<?php namespace Weboap\Visitor\Geo\Max;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

use Weboap\Visitor\Geo\Interfaces\GeoInterface;
use Illuminate\Config\Repository as Config;

use Illuminate\Http\Request as Request;


class MaxMind implements GeoInterface{
    
    
    protected $reader;
    
    protected $config;
    
    protected $request;
    
    public function __construct( Config $config, Request $request )
    {
       $db = $config->get('visitor::maxmind.path');
       $this->request = $request;
       
       $this->reader = new Reader( $db );
    }
    

    
    public function locate( $ip = null )
    {
        
        $ip = isset( $ip ) ? $ip : $this->get_ip();
        
        if( ! $this->_is_ip4( $ip ) && ! $this->_is_ipv6( $ip ) )  return array();
        
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
            
            return array();
        };
           
    }
    
    
    private function _is_ip4( $ip )
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
    
    private function _is_ipv6( $ip )
    { 
	return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)!== false;
    }
    
    public function get_ip()
    {
        return $this->request->getClientIp();
    }
    
  
    
}

