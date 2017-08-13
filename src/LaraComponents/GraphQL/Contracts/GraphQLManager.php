<?php

namespace LaraComponents\GraphQL\Contracts;

interface GraphQLManager
{
    /**
     * Get a schema implementation by name.
     *
     * @param  string  $name
     * @return void
     */
    public function schema($name = null);
}
