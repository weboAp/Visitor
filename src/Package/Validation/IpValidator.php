<?php namespace Weboap\Visitor\Validation;


class IpValidator implements ValidationInterface {
    
    
    public function validate( $ip )
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
  
}
