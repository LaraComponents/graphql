<?php

return [
    /*
    |--------------------------------------------------------------------------
    | The name of the default schema
    |--------------------------------------------------------------------------
    */

    'schema' => 'default',

    /*
    |--------------------------------------------------------------------------
    | The schemas for query
    |--------------------------------------------------------------------------
    */
    'schemas' => [
        'default' => \App\GraphQL\Schemas\DefaultSchema::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Route configuration
    |--------------------------------------------------------------------------
    */

    'route' => [

        /*
        |--------------------------------------------------------------------------
        | Prefix for route
        |--------------------------------------------------------------------------
        |
        | Default: graphql
        |
        */

        'prefix' => 'graphql',

        /*
        |--------------------------------------------------------------------------
        | Any middleware for the graphql route group
        |--------------------------------------------------------------------------
        */

        'middleware' => [],

        /*
        |--------------------------------------------------------------------------
        | Available methods for route
        |--------------------------------------------------------------------------
        */

        'methods' => ['GET', 'POST'],

        /*
        |--------------------------------------------------------------------------
        | The controller to use in GraphQL request
        |--------------------------------------------------------------------------
        */

        'controller' => '\LaraComponents\GraphQL\GraphQLController@index',
    ],

    /*
    |--------------------------------------------------------------------------
    | Response configuration
    |--------------------------------------------------------------------------
    */

    'response' => [

        /*
         * Any headers that will be added to the response returned by the default controller
         */

        'headers' => [],

        /*
         * Any json encoding options when returning a response from the default controller
         */

        'json_options' => 0,
    ],

    /*
    |--------------------------------------------------------------------------
    | List types for Type Facade
    |--------------------------------------------------------------------------
    */
    'types' => [
        'bool' => \Youshido\GraphQL\Type\Scalar\BooleanType::class,
        'dateTime' => \Youshido\GraphQL\Type\Scalar\DateTimeType::class,
        'dateTimeTz' => \Youshido\GraphQL\Type\Scalar\DateTimeTzType::class,
        'date' => \Youshido\GraphQL\Type\Scalar\DateType::class,
        'float' => \Youshido\GraphQL\Type\Scalar\FloatType::class,
        'id' => \Youshido\GraphQL\Type\Scalar\IdType::class,
        'int' => \Youshido\GraphQL\Type\Scalar\IntType::class,
        'string' => \Youshido\GraphQL\Type\Scalar\StringType::class,
        'timestamp' => \Youshido\GraphQL\Type\Scalar\TimestampType::class,
        'notNull' => \Youshido\GraphQL\Type\NonNullType::class,
        'listOf' => \Youshido\GraphQL\Type\ListType\ListType::class,

        /*
         * Your types...
         */

    ],
];
