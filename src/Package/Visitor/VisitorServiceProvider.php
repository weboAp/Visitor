<?php namespace Weboap\Visitor;


use Illuminate\Support\ServiceProvider;

class VisitorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('weboap/visitor');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->RegisterStorage();
		
		$this->RegisterGeoLocationBinding();
		
		$this->RegisterVisitorBinding();
		
		$this->RegisterBooting();
	}
	
	public function RegisterVisitorBinding()
	{
		$this->app['visitor'] = $this->app->share(function($app)
			{
			    return new Visitor(
						 $this->app->make('Weboap\Visitor\Storage\VisitorInterface'),
						 $this->app['visitor.geo'],
						 array(
							$this->app->make('Weboap\Visitor\Validation\IpValidator'),
							$this->app->make('Weboap\Visitor\Validation\IgnoredIpChecker')
							)
						 
					      );
			});
	
	}
	
	
	public function RegisterGeoLocationBinding()
	{
		$this->app['visitor.geo'] = $this->app->share(function($app)
			{
			    $reader = new \GeoIp2\Database\Reader( $this->app->make('config')->get('visitor::maxmind_db_path'));
			    
			    return new \Weboap\Visitor\Libs\Geo\GeoLocation(
						 $this->app->make('config'),
						 $reader						 
					      );
			});
	
	}
	
	
	public function RegisterBooting()
	{
		 $this->app->booting(function()
				{
				   $loader = \Illuminate\Foundation\AliasLoader::getInstance();
				   $loader->alias('Visitor', 'Weboap\Visitor\Facades\VisitorFacade');
			
				    
				});
		 
	}
	
	protected function RegisterStorage()
	{
		$this->app->singleton(
			'Weboap\Visitor\Storage\VisitorInterface',
			'Weboap\Visitor\Storage\QbVisitorRepository'
                );
	}	

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('visitor');
	}

}