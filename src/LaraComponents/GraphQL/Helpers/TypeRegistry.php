<?php

namespace LaraComponents\GraphQL\Helpers;

use InvalidArgumentException;

class TypeRegistry
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The array of types.
     *
     * @var array
     */
    protected $types = [];

    /**
     * The array of resolved types.
     *
     * @var array
     */
    protected $instances = [];

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @param  array  $types
     * @return void
     */
    public function __construct($app, array $types = [])
    {
        $this->app = $app;

        foreach ($types as $name => $class) {
            $this->setType($class, is_numeric($name) ? null : $name);
        }
    }

    /**
     * Set type into registry.
     *
     * @param string $class
     * @param string $name
     */
    public function setType($class, $name = null)
    {
        $name = $this->getName($class, $name);
        $this->types[$name] = $class;
    }

    /**
     * Resolve type from registry.
     *
     * @param  string $type
     * @param  string $parameters
     * @return mixed
     * @throws \InvalidArgumentException
     */
    protected function resolveType($type, array $parameters)
    {
        if (! array_key_exists($type, $this->types)) {
            throw new InvalidArgumentException(sprintf('The type "%s" is not found.', $type));
        }

        if (count($parameters)) {
            return $this->make($type, $parameters);
        }

        if (! array_key_exists($type, $this->instances)) {
            $this->instances[$type] = $this->make($type, $parameters);
        }

        return $this->instances[$type];
    }

    /**
     * Make a new instance of type.
     *
     * @param  string $type
     * @param  string $parameters
     * @return mixed
     */
    protected function make($type, $parameters)
    {
        $class = $this->types[$type];

        if (count($parameters)) {
            return new $class(...$parameters);
        }

        return new $class();
    }

    /**
     * Get name  from className.
     * @param  string $class
     * @param  string $name
     * @return string
     */
    protected function getName($class, $name = null)
    {
        if ($name) {
            return $name;
        }

        if ($prevPos = strrpos($class, '\\')) {
            $class = substr($class, $prevPos + 1);
        }

        if (substr($class, -4) == 'Type') {
            $class = substr($class, 0, -4);
        }

        return lcfirst($class);
    }

    /**
     * Dynamically call the type instance.
     *
     * @param  string $type
     * @param  array $parameters
     * @return mixed
     */
    public function __call($type, $parameters)
    {
        return $this->resolveType($type, $parameters);
    }
}
