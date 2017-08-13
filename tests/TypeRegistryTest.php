<?php

namespace LaraComponents\GraphQL\Test;

use LaraComponents\GraphQL\Facades\Type;
use LaraComponents\GraphQL\Helpers\TypeRegistry;

class TypeRegistryTest extends TestCase
{
    /**
     * Test instance.
     *
     * @test
     */
    public function testInstance()
    {
        $types = $this->app->make('graphql.types');

        $this->assertInstanceOf(TypeRegistry::class, $types);
    }

    /**
     * Test types.
     *
     * @test
     */
    public function testTypeFromFacade()
    {
        $this->assertInstanceOf(\Youshido\GraphQL\Type\Scalar\BooleanType::class, Type::bool());
        $this->assertInstanceOf(\Youshido\GraphQL\Type\Scalar\DateTimeType::class, Type::dateTime());
        $this->assertInstanceOf(\Youshido\GraphQL\Type\Scalar\DateTimeTzType::class, Type::dateTimeTz());
        $this->assertInstanceOf(\Youshido\GraphQL\Type\Scalar\DateType::class, Type::date());
        $this->assertInstanceOf(\Youshido\GraphQL\Type\Scalar\FloatType::class, Type::float());
        $this->assertInstanceOf(\Youshido\GraphQL\Type\Scalar\IdType::class, Type::id());
        $this->assertInstanceOf(\Youshido\GraphQL\Type\Scalar\IntType::class, Type::int());
        $this->assertInstanceOf(\Youshido\GraphQL\Type\Scalar\StringType::class, Type::string());
        $this->assertInstanceOf(\Youshido\GraphQL\Type\Scalar\TimestampType::class, Type::timestamp());

        $this->assertInstanceOf(\Youshido\GraphQL\Type\NonNullType::class, Type::notNull(Type::id()));
        $this->assertInstanceOf(\Youshido\GraphQL\Type\ListType\ListType::class, Type::listOf(Type::id()));

        $this->assertSame(Type::bool(), Type::bool());
        $this->assertSame(Type::dateTime(), Type::dateTime());
        $this->assertSame(Type::dateTimeTz(), Type::dateTimeTz());
        $this->assertSame(Type::date(), Type::date());
        $this->assertSame(Type::float(), Type::float());
        $this->assertSame(Type::id(), Type::id());
        $this->assertSame(Type::int(), Type::int());
        $this->assertSame(Type::string(), Type::string());
        $this->assertSame(Type::timestamp(), Type::timestamp());

        $this->assertNotSame(Type::notNull(Type::id()), Type::notNull(Type::id()));
        $this->assertNotSame(Type::listOf(Type::id()), Type::listOf(Type::id()));

        $this->assertEquals(Type::dateTime('d-m-Y H:i:s'), Type::dateTime('d-m-Y H:i:s'));
        $this->assertNotSame(Type::dateTime('d-m-Y H:i:s'), Type::dateTime('d-m-Y H:i:s'));
        $this->assertNotEquals(Type::dateTime('d-m-Y H:i'), Type::dateTime('d-m-Y H:i:s'));
    }
}
