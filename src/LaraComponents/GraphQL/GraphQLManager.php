<?php

namespace LaraComponents\GraphQL;

use InvalidArgumentException;
use LaraComponents\GraphQL\Contracts\GraphQLManager as GraphQLManagerContract;

class GraphQLManager implements GraphQLManagerContract
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The array of resolved schemas.
     *
     * @var array
     */
    protected $schemas = [];

    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Get a schema implementation by name.
     *
     * @param  string  $name
     * @return void
     */
    public function schema($name = null)
    {
        $name = $name ?: $this->getDefaultSchema();

        return $this->schemas[$name] = $this->get($name);
    }

    /**
     * Attempt to get the schema from the local cache.
     *
     * @param  string  $name
     * @return \Youshido\GraphQL\Schema\AbstractSchema
     */
    protected function get($name)
    {
        return isset($this->schemas[$name]) ? $this->schemas[$name] : $this->resolve($name);
    }

    /**
     * Resolve the given store.
     *
     * @param  string  $name
     * @return \Youshido\GraphQL\Schema\AbstractSchema
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $class = $this->getClass($name);

        if (is_null($class)) {
            throw new InvalidArgumentException("Schema [{$name}] is not defined.");
        }

        return $this->app->make($class);
    }

    /**
     * Get the schema configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getClass($name)
    {
        return $this->app['config']["graphql.schemas.{$name}"];
    }

    /**
     * Get the default schema name.
     *
     * @return string
     */
    public function getDefaultSchema()
    {
        return $this->app['config']['graphql.schema'];
    }
}
