<?php namespace Weboap\Visitor;

use Weboap\Visitor\Storage\VisitorInterface as VisitorInterface;
use Weboap\Visitor\Libs\Geo\GeoLocation;

//use Illuminate\Cache\CacheManager as Cache;
use Illuminate\Exception\Handler as Exception;
use Carbon\Carbon as c;



class Visitor {
	

	protected $storage;
	protected $validators;
	protected $geo;
	
	protected $_myCount = 3; 
	
	public function __construct( 	VisitorInterface $storage,
					GeoLocation $geo,
					array $validators = array()
				    )
	{
		$this->storage = $storage;
		$this->geo = $geo;
		$this->validators = $validators;
	}
	
	
	public function add( $ip )
	{
		if( ! $this->_check_ip( $ip ) ) return;
		
		$geo = $this->geo->locate($ip);
		
		dd($geo);
	}
	
	
	
	private function _check_ip( $ip )
	{
		foreach ($this->validators as $validator)
		{
			if( ! $validator->validate( $ip ) ) return false;
		}
		
		return true;
	}
	

	
    
    
}

class InvalidArgumentException extends Exception {}