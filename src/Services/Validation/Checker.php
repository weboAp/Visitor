<?php namespace Weboap\Visitor\Services\Validation;

use Whitelist\Check;
use  Exception;
use Illuminate\Config\Repository as Config;

class Checker implements ValidationInterface {
    
    protected $checker;
    
    protected $config;
    
    public function __construct(Check $checker, Config $config)
    {
      $this->checker  = $checker;
      $this->config = $config;
      
    }
    
    public function validate( $ip )
    {
        $list =  $this->config->get('visitor::ignored');
        
        if(! is_array($list)) $list = array();
       
        try {
            $this->checker->whitelist( $list  );
            }
            catch (InvalidArgumentException $e) {
                
                throw new InvalidArgumentException('invalid definition encountered in white list!');
            };
         /**
          *if ip is in the ignored list return false mean dont register
         * if ip is not in ignored list return  true  mean register
         **/
        return ! $this->checker->check( $ip );
        
    }
    
    
   
    
    
}



class InvalidArgumentException extends Exception {}