<?php namespace Weboap\Visitor;

use Weboap\Visitor\Storage\VisitorInterface;
use Weboap\Visitor\Services\Geo\GeoInterface;

use Weboap\Visitor\Services\Cache\CacheClass;
use Illuminate\Config\Repository as Config;
use Carbon\Carbon as c;
use Countable;


/**
 * Class Visitor
 * @package Weboap\Visitor
 */
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


    /**
     * @var Ip
     */
    protected $ip;
	
	/**
	* The Geo Interface
	*/
	protected $geo;


    /**
     * @param VisitorInterface $storage
     * @param GeoInterface $geo
     * @param Ip $ip
     * @param Config $config
     * @param CacheClass $cache
     */
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


    /**
     * @param null $ip
     * @return null
     */
    public function get( $ip = null )
	{
		if( ! isset( $ip ) )
		{
			$ip = $this->ip->get();
		}
		
		if( $this->ip->isValid( $ip ) )
		{
			return $this->storage->get( $ip );
		}
		
		return null;	
	}


    /**
     *
     */
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


    /**
     * @param $ip
     */
    public function forget( $ip )
	{
		if( ! $this->ip->isValid( $ip ) ) return;
		
		//delete the ip from db
		$this->storage->delete( $ip );
		
		// Clear the database cache
		$this->cache->destroy( $this->tableName );
	
			
	}


    /**
     * @param $ip
     * @return bool
     */
    public function has( $ip )
	{
		if( ! $this->ip->isValid( $ip ) ) return false;
		
		return $this->count( $ip ) > 0 ;
	
	}

    /**
     * @param null $ip
     * @return mixed
     */
    public function count( $ip = null)
	{
		//if ip null then return count of all visits
		return $this->storage->count( $ip );
	}

    /**
     * @return mixed
     */
    public function all()
	{
		return $this->storage->all();
	}

    /**
     * @return mixed
     */
    public function clicks()
	{
		return $this->storage->clicksSum();
	}

    /**
     * @param $start
     * @param $end
     * @return mixed
     */
    public function range($start, $end)
	{
		$start = date( 'Y-m-d H:i:s', strtotime( $start ));
		$end = date( 'Y-m-d 23:59:59', strtotime( $end ));
		
		
		return $this->storage->range($start, $end);
	}
	
	
	
	

	
    
    
}

