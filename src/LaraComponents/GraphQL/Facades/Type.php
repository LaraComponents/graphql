<?php

namespace LaraComponents\GraphQL\Facades;

use Illuminate\Support\Facades\Facade;

class Type extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'graphql.types';
    }
}
