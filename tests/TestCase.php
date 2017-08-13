<?php

namespace LaraComponents\GraphQL\Test;

use Youshido\GraphQL\Execution\Processor;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected $processor;

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->processor = $this->app->make(Processor::class);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('graphql.schema', 'default');
        $app['config']->set('graphql.schemas.default', Schema::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            \LaraComponents\GraphQL\ServiceProvider::class,
        ];
    }
}
