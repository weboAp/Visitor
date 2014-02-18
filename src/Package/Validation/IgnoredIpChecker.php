<?php namespace Weboap\Visitor\Validation;

use Whitelist\Check;
use  Exception;
use Illuminate\Config\Repository as Config;

class IgnoredIpChecker implements ValidationInterface {
    
    protected $checker;
    
    protected $config;
    
    public function __construct(Check $checker = null, Config $config = null)
    {
      $this->checker  = isset( $checker ) ?   $checker : new Whitelist\Check();
      $this->config = isset( $config ) ? $config : App::make('config');
      
    }
    
    public function validate( $ip )
    {
        try {
            $this->checker->whitelist(  $this->config->get('visitor::ignored') );
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