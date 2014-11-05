<?php namespace AdamWathan\Faktory;

use Illuminate\Support\ServiceProvider;

class FaktoryServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['vehikl.faktory'] = $this->app->share(function($app)
        {
            return new Faktory;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('faktory');
    }

}
