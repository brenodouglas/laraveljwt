<?php
namespace LaravelJwt;

use Illuminate\Support\ServiceProvider;
use LaravelJwt\Middlewares\JwtAuthMiddleware;
use LaravelJwt\Service\JwtAuth;

class JwtProvider extends ServiceProvider
{

    public function boot()
    {
        $router = $this->app['router'];
        $router->middleware('authjwt', JwtAuthMiddleware::class);

        $this->publishConfig();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('jwtauth', function ($app) {
            return new JwtAuth();
        });
    }

    /**
     * Publish jwt config file
     */
    public function publishConfig()
    {
        $this->publishes([__DIR__ . '/../resources/config/jwt.php' => config_path('jwt.php')], 'config');
    }
}