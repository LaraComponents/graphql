<?php

namespace LaraComponents\GraphQL;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Youshido\GraphQL\Execution\Processor;

class GraphQLController extends Controller
{
    public function index(Request $request, Processor $processor)
    {
        list($queries, $isMultiQueryRequest) = $this->getPayload($request);

        $response = array_map(function ($query) use ($processor) {
            return $this->executeQuery($processor, $query);
        }, $queries);

        return new JsonResponse(
            $isMultiQueryRequest ? $response : $response[0],
            200,
            config('graphql.response.headers', []),
            config('graphql.response.json_options', 0)
        );
    }

    protected function getPayload(Request $request)
    {
        $isMultiQueryRequest = false;
        $queries = $request->all();

        if (array_keys($queries) === range(0, count($queries) - 1)) {
            $isMultiQueryRequest = true;
        } else {
            $queries = [$queries];
        }

        return [$queries, $isMultiQueryRequest];
    }

    protected function executeQuery($processor, $input)
    {
        $query = array_get($input, 'query', null);
        $variables = array_get($input, 'variables');
        $variables = is_string($variables) ? json_decode($variables, true) ?: [] : [];

        return $processor->processPayload($query, $variables)->getResponseData();
    }
}
