<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Yangqi\Htmldom\Htmldom;


class HtmlDomServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('Yangqi\Htmldom\Htmldom', function($app)
        {
            return new Htmldom();
        });
	}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Yangqi\Htmldom\Htmldom'];
    }

}
