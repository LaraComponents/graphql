<?php

namespace LaraComponents\GraphQL;

use Youshido\GraphQL\Execution\Processor;
use Youshido\GraphQL\Schema\AbstractSchema;
use LaraComponents\GraphQL\Helpers\TypeRegistry;
use LaraComponents\GraphQL\Console\TypeMakeCommand;
use LaraComponents\GraphQL\Console\FieldMakeCommand;
use LaraComponents\GraphQL\Console\SchemaMakeCommand;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaraComponents\GraphQL\Contracts\GraphQLManager as GraphQLManagerContract;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

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

        $router->group([
            'prefix' => config('graphql.route.prefix'),
            'middleware' => config('graphql.route.middleware'),
        ], function () {
            include __DIR__.'/routes.php';
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

        $this->app->singleton(GraphQLManager::class, function ($app) {
            return new GraphQLManager($app);
        });

        $this->app->singleton(AbstractSchema::class, function ($app) {
            return $app->make(GraphQLManager::class)->schema();
        });

        $this->app->alias(
            GraphQLManager::class, GraphQLManagerContract::class
        );

        $this->app->singleton(Processor::class, function ($app) {
            return new Processor($app->make(AbstractSchema::class));
        });

        $this->app->singleton('graphql.types', function ($app) {
            $types = config('graphql.types') ?: [];

            return new TypeRegistry($app, $types);
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
