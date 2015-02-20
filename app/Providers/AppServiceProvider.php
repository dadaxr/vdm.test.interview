<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);

        $this->app->singleton('VDMMongoDB', function($app)
        {
            $mongo_host = env('MONGO_HOST');
            $db = env('MONGO_DB');
            $cnx_string = 'mongodb://'.$mongo_host.':'.env('MONGO_PORT');


            $cnx = new \MongoClient($cnx_string,array(
                'username' => env('MONGO_USER'),
                'password' => env('MONGO_PASSWORD'),
                'db' => $db
            ));

            return $cnx->$db;
        });




	}

}
