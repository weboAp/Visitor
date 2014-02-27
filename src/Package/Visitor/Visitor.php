<?php namespace Weboap\Visitor;

use Weboap\Visitor\Storage\Interfaces\VisitorInterface as VisitorInterface;
use Weboap\Visitor\Geo\Interfaces\GeoInterface;

use Illuminate\Cache\CacheManager as Cache;
use Illuminate\Config\Repository as Config;
use Illuminate\Exception\Handler as Exception;
use Carbon\Carbon as c;
use Countable;


class Visitor implements Countable{
	
	
	/**
	* The Config array
	* @var string
	*/	
	protected $tableName = null;
	
	/**
	* The Option Repository Interface Instance
	* @var OpenInterface
	*/
	protected $storage;
	
	/**
	* The Cache Manager Instance
	* @var Cache
	*/
	protected $cache;
	
	/**
	* The Config Instance
	* @var Config
	*/
	protected $config;

	/**
	* The Validators array
	* @array Validator
	*/
	protected $validators;
	
	/**
	* The Geo Interface
	*/
	protected $geo;
	
	
	
	
	public function __construct( VisitorInterface $storage,
				    GeoInterface $geo,
				    array $validators = array(),
				    Config $config,
				    Cache $cache
				    )
	{
		$this->storage = $storage;
		$this->geo = $geo;
		$this->validators = $validators;
		$this->config = $config;
		$this->cache = $cache;
		
		
		$this->tableName = $this->config->get('visitor::table');
		
	}
	
	
	public function get( $ip )
	{
		if( is_string( $ip ) && $this->_check_ip( $ip ) ) 
		{
			return $this->storage->get( $ip );
		}
		return null;
	}
	
	
	public function reg( $ip )
	{
		if( is_string( $ip ) && $this->_check_ip( $ip ) ) 
		{
		
			$geo = $this->geo->locate( $ip );
			
			if( $this->has( $ip ) )
			{
				//ip already exist in db.
				$this->storage->increment( $ip );
				
			}
			else
			{
				//ip doesnt exist  in db
				$data = array(
						'ip'		=> $ip,
						'geo'		=> serialize( $geo ),
						'clicks' 	=> 1,
						'updated_at'	=> c::now(),
						'created_at'	=> c::now()
						);
				$this->storage->create( $data );
				
			}
			
		// Clear the database cache
		$this->cache->forget( $this->tableName );
		
		}
		
	}
	
	
	public function forget( $ip )
	{
		//delete the ip from db
		$this->storage->delete( $ip );

		// Clear the database cache
		$this->cache->forget( $this->tableName );
	}	
	
	
	public function has( $ip )
	{
		return $this->count( $ip ) > 0 ;
	}
	
	public function count( $ip = null)
	{
		return $this->storage->count( $ip );
	}
	
	public function all()
	{
		return $this->storage->all();
	}
	
	public function clicks()
	{
		return $this->storage->clicksSum();
	}

	public function range($start, $end)
	{
		$start = date( 'Y-m-d H:i:s', strtotime( $start ));
		$end = date( 'Y-m-d 23:59:59', strtotime( $end ));
		
		
		return $this->storage->range($start, $end);
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