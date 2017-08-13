<?php

namespace LaraComponents\GraphQL\Console;

use Illuminate\Console\GeneratorCommand;

class TypeMakeCommand extends GeneratorCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:graphql:type {name} {--type= : Create a specific type.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new GraphQL type class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Type';

    /**
     * The type to create.
     *
     * @var string
     */
    protected $graphqlType = null;

    /**
     * The list of type and namespaces.
     *
     * @var array
     */
    protected $graphqlTypes = [
        'AbstractType' => 'Youshido\GraphQL\Type\AbstractType',
        'AbstractScalarType' => 'Youshido\GraphQL\Type\Scalar\AbstractScalarType',
        'AbstractObjectType' => 'Youshido\GraphQL\Type\Object\AbstractObjectType',
        'AbstractMutationObjectType' => 'Youshido\GraphQL\Type\Object\AbstractMutationObjectType',
        'AbstractInputObjectType' => 'Youshido\GraphQL\Type\InputObject\AbstractInputObjectType',
        'AbstractInterfaceType' => 'Youshido\GraphQL\Type\InterfaceType\AbstractInterfaceType',
        'AbstractEnumType' => 'Youshido\GraphQL\Type\Enum\AbstractEnumType',
        'AbstractListType' => 'Youshido\GraphQL\Type\ListType\AbstractListType',
        'AbstractUnionType' => 'Youshido\GraphQL\Type\Union\AbstractUnionType',
    ];

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $this->determineWhatShouldBeCreated();

        $stub = parent::buildClass($name);
        $stub = $this->replaceDummy($stub, $this->graphqlType, 'DummyType');

        return $this->replaceDummy($stub, $this->graphqlTypes[$this->graphqlType], 'DummyUseType');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/Type.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\GraphQL\Types';
    }

    /**
     * Determine the type to create.
     *
     * @return void
     */
    protected function determineWhatShouldBeCreated()
    {
        $optionType = (string) $this->option('type');

        if (array_key_exists($optionType, $this->graphqlTypes)) {
            $this->graphqlType = $optionType;

            return;
        }

        $this->promptForType();
    }

    /**
     * Prompt for which type to create.
     *
     * @return void
     */
    protected function promptForType()
    {
        $choice = $this->choice(
            'Which type would you like to create?',
            array_map(function ($type) {
                return '<comment>'.$type.'</comment>';
            }, array_keys($this->graphqlTypes))
        );

        $this->graphqlType = strip_tags($choice);
    }

    /**
     * Replace the extends type for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceDummy($stub, $name, $dummy)
    {
        return str_replace($dummy, $name, $stub);
    }
}
