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
    protected $signature = 'make:graphql:schema {name} {--force : Create the class even if the schema already exists.}';

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
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() === false && ! $this->option('force')) {
            return;
        }
    }

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
