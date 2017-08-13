<?php

namespace LaraComponents\GraphQL\Console;

use Illuminate\Console\GeneratorCommand;

class FieldMakeCommand extends GeneratorCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:graphql:field {name} {--input : Create Input field.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new GraphQL field class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Field';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('input')) {
            return __DIR__.'/stubs/InputField.stub';
        }

        return __DIR__.'/stubs/Field.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\GraphQL\Fields';
    }
}
