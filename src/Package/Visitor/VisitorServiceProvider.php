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
		$this->RegisterStorageInterface();
		$this->RegisterGeoInterface();
		
		$this->RegisterVisitorInstance();
		
		$this->RegisterBooting();
	}
	
	public function RegisterVisitorInstance()
	{
		$this->app['visitor'] = $this->app->share(function($app)
			{
			   
			    
			    return new Visitor(
						 $app->make('Weboap\Visitor\Storage\Interfaces\VisitorInterface'),
						 $app->make('Weboap\Visitor\Geo\Interfaces\GeoInterface', array( $app['config'], $app['request'] )),
						 array(
							$app->make('Weboap\Visitor\Validation\IpValidator'),
							$app->make('Weboap\Visitor\Validation\IgnoredIpChecker')
							),
						 $app->make('config'),
						 $app->make('cache')
						 
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
	
	protected function RegisterStorageInterface()
	{
		$this->app->singleton(
			'Weboap\Visitor\Storage\Interfaces\VisitorInterface',
			'Weboap\Visitor\Storage\QbVisitorRepository'
                );
	}
	
	protected function RegisterGeoInterface()
	{
		
		
		$this->app->singleton(
                    'Weboap\Visitor\Geo\Interfaces\GeoInterface',
                    'Weboap\Visitor\Geo\Max\MaxMind'
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