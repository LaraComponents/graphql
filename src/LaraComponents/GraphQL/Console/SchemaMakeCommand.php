<?php

namespace LaraComponents\GraphQL\Console;

use Illuminate\Console\GeneratorCommand;

class SchemaMakeCommand extends GeneratorCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:graphql:schema {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new GraphQL schema class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Schema';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/Schema.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\GraphQL\Schemas';
    }
}
