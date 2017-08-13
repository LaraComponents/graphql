<?php

namespace LaraComponents\GraphQL\Test;

use Youshido\GraphQL\Schema\AbstractSchema;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Config\Schema\SchemaConfig;

class Schema extends AbstractSchema
{
    public function build(SchemaConfig $config)
    {
        $query = $config->getQuery();

        $query->addFields([
            'foo' => [
                'type' => new StringType(),
                'resolve' => function ($context, $args) {
                    return 'bar';
                },
            ],
        ]);
    }
}
