<?php namespace Weboap\Visitor;


use Illuminate\Support\ServiceProvider;

class VisitorServiceProvider extends ServiceProvider {

	

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		
		
		$this->publishes([
				  realpath(__DIR__.'/migrations') => base_path('/database/migrations') ],
				 'migrations');
		
		$this->publishes([
				__DIR__.'/config/visitor.php' => config_path('visitor.php'),
			    ]);
		
		
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerBindings();
		
		$this->RegisterIp();
		
		$this->RegisterVisitor();
		
		$this->RegisterBooting();
	}
	
	public function RegisterVisitor()
	{
		$this->app->singleton('visitor', function($app)
			{
			   
			    
			    return new Visitor(
						 $app['Weboap\Visitor\Storage\VisitorInterface'],
						 $app['Weboap\Visitor\Services\Geo\GeoInterface'],
						 $app['ip'],
						 $app['Weboap\Visitor\Services\Cache\CacheInterface']
						 
					      );
			});
		
		$this->app->bind('Weboap\Visitor\Visitor', function($app) {
			return $app['visitor'];
		    });
	
	}
	
	
	public function RegisterIp()
	{
		$this->app->singleton('ip', function($app)
			{
			    return new Ip(
					$app->make('request'),
					array(
					       $app->make('Weboap\Visitor\Services\Validation\Validator'),
					       $app->make('Weboap\Visitor\Services\Validation\Checker')
					       )
						 
					      );
			});
	
	}
	
	

	
	public function registerBooting()
	{
		 $this->app->booting(function()
				{
				   $loader = \Illuminate\Foundation\AliasLoader::getInstance();
				   $loader->alias('Visitor', 'Weboap\Visitor\Facades\VisitorFacade');
			
				    
				});
	}
	
	
	
	protected function registerBindings()
	{
		$this->app->singleton(
			'Weboap\Visitor\Storage\VisitorInterface',
			'Weboap\Visitor\Storage\QbVisitorRepository'
                );
		
		$this->app->singleton(
                    'Weboap\Visitor\Services\Geo\GeoInterface',
                    'Weboap\Visitor\Services\Geo\MaxMind'
                );
		
		$this->app->singleton(
                    'Weboap\Visitor\Services\Cache\CacheInterface',
                    'Weboap\Visitor\Services\Cache\CacheClass'
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