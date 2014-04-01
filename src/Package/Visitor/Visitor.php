<?php namespace Weboap\Visitor;

use Weboap\Visitor\Storage\VisitorInterface;
use Weboap\Visitor\Services\Geo\GeoInterface;

use Weboap\Visitor\Services\Cache\CacheClass;
use Illuminate\Config\Repository as Config;
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
	* The Cache Interface
	* @var Weboap\Visitor\Services\Cache\CacheClass
	*/
	protected $cache;
	
	/**
	* The Config Instance
	* @var Config
	*/
	protected $config;

	
	protected $ip;
	
	/**
	* The Geo Interface
	*/
	protected $geo;
	
	
	
	
	public function __construct( 	VisitorInterface $storage,
					GeoInterface $geo,
					Ip $ip,
					Config $config,
					CacheClass $cache
				    )
	{
		$this->storage = $storage;
		$this->geo = $geo;
		$this->ip = $ip;
		$this->config = $config;
		$this->cache = $cache;
		
		
		$this->tableName = $this->config->get('visitor::table');
		
	}
	
	
	
	
	public function get( $ip = null )
	{
		if( is_null ( $ip ) )
		{
			$ip = $this->ip->get();
		}
		
		if( $this->ip->isValid( $ip ) )
		{
			return $this->storage->get( $ip );
		}
		
		return null;	
	}
	
	
	
	
	public function log()
	{
		
		$ip = $this->ip->get();
		
		if( ! $this->ip->isValid( $ip ) ) return;
		
		
		if( $this->has( $ip ) )
		{
			//ip already exist in db.
			$this->storage->increment( $ip );
			
		}
		else
		{
			$geo = $this->geo->locate( $ip );
		
			$country =  array_key_exists('country_code', $geo) ? $geo['country_code'] : null;
		
			
			//ip doesnt exist  in db
			$data = array(
					'ip'		=> $ip,
					'country'	=> $country,
					'clicks' 	=> 1,
					'updated_at'	=> c::now(),
					'created_at'	=> c::now()
					);
			$this->storage->create( $data );
			
		}
			
		// Clear the database cache
		$this->cache->destroy( $this->tableName );
		
		
		
	}
	
	
	public function forget( $ip )
	{
		if( ! $this->ip->isValid( $ip ) ) return;
		
		//delete the ip from db
		$this->storage->delete( $ip );
		
		// Clear the database cache
		$this->cache->destroy( $this->tableName );
	
			
	}	
	
	
	public function has( $ip )
	{
		if( ! $this->ip->isValid( $ip ) ) return false;
		
		return $this->count( $ip ) > 0 ;
	
	}
	
	public function count( $ip = null)
	{
		//if ip null then return count of all visits
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
	
	
	
	

	
    
    
}

