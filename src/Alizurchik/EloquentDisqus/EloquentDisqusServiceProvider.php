<?php namespace Alizurchik\EloquentDisqus;

use Illuminate\Support\ServiceProvider;

class EloquentDisqusServiceProvider extends ServiceProvider {

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
		$this->package('alizurchik/eloquent-disqus');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['eloquent.disqus'] = $this->app->share(function ($app) {
				return new EloquentDisqus($app['view']);
			}
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('eloquent.disqus');
	}

}
