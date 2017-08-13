<?php

namespace LaraComponents\GraphQL\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class TypeMakeCommand extends GeneratorCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature  = 'make:graphql:type {name} {--force : Create the class even if the type already exists.}
                                                      {--type= : Create a specific type.}';

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
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        // First we will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ($this->alreadyExists($this->getNameInput()) && ! $this->option('force')) {
            $this->error($this->type.' already exists!');

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');
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
            "Which type would you like to create?",
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
