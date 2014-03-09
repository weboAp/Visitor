<?php namespace Weboap\Visitor\Validation;


class IpValidator implements ValidationInterface {
    
    
    public function validate( $ip )
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
    
    
//    public function isIPv4( $ip )
//    { 
//	return filter_var($ip, FILTER_VALIDATE_IP) !== false;
//    }
    
    public function isIPv6( $ip )
    { 
	return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)!== false;
    }
  
}
