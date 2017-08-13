<?php

namespace LaraComponents\GraphQL\Test;

use Youshido\GraphQL\Schema\AbstractSchema;

class GraphQLTest extends TestCase
{
    /**
     * Test schema default.
     *
     * @test
     */
    public function testSchema()
    {
        $schema = $this->app->make(AbstractSchema::class);

        $this->assertInstanceOf(Schema::class, $schema);
        $this->assertInstanceOf(Schema::class, $this->processor->getExecutionContext()->getSchema());
    }

    /**
     * Test endpoint.
     *
     * @test
     */
    public function testEndpoint()
    {
        $response = $this->call('GET', '/graphql');
        $content = $response->getData(true);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('errors', $content);
        $this->assertEquals($content['errors'], [
            [
                'message' => 'Must provide an operation.',
            ],
        ]);
    }

    /**
     * Test schema default.
     *
     * @test
     */
    public function testSimpleQuery()
    {
        $response = $this->call('GET', '/graphql', [
            'query' => 'query{foo}',
        ]);
        $content = $response->getData(true);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('data', $content);
        $this->assertEquals($content['data'], [
            'foo' => 'bar',
        ]);
    }
}
