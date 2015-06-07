<?php namespace Weboap\Visitor\Services\Validation;


class Validator implements ValidationInterface {
    
    
    public function validate( $ip )
    {
         if( $this->_is_ip4( $ip ) || $this->_is_ipv6( $ip ) ) return true;
    }
    
    
    private function _is_ip4( $ip )
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
    
    private function _is_ipv6( $ip )
    { 
	return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)!== false;
    }
  
}
