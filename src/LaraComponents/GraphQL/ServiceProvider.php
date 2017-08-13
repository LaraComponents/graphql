<?php

namespace LaraComponents\GraphQL;

use Youshido\GraphQL\Execution\Processor;
use LaraComponents\GraphQL\Console\TypeMakeCommand;
use LaraComponents\GraphQL\Console\FieldMakeCommand;
use LaraComponents\GraphQL\Console\SchemaMakeCommand;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'LaraComponents\GraphQL';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootPublishes();
        $this->bootRouter();
    }

    /**
     * Bootstrap router.
     *
     * @return void
     */
    protected function bootRouter()
    {
        $router = $this->app->make('router');
        $router->group(['namespace' => $this->namespace], function () {
            return __DIR__.'/routes.php';
        });
    }

    /**
     * Bootstrap publishes.
     *
     * @return void
     */
    protected function bootPublishes()
    {
        $this->publishes([$this->configPath() => config_path('graphql.php')], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'graphql');
        $this->registerCommands();

        $this->app->singleton('graphql.schema', function ($app) {
            return $app->make(config('graphql.schema'));
        });

        $this->app->singleton(Processor::class, function ($app) {
            return new Processor($app->make('graphql.schema'));
        });
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->app->bind('command.make:graphql:field', FieldMakeCommand::class);
        $this->app->bind('command.make:graphql:schema', SchemaMakeCommand::class);
        $this->app->bind('command.make:graphql:type', TypeMakeCommand::class);

        $this->commands([
            'command.make:graphql:field',
            'command.make:graphql:schema',
            'command.make:graphql:type',
        ]);
    }

    /**
     * Return GraphQL config path.
     *
     * @return string
     */
    protected function configPath()
    {
        return __DIR__.'/../../config/graphql.php';
    }
}
