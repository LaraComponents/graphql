<?php

namespace LaraComponents\GraphQL;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Youshido\GraphQL\Execution\Processor;

class GraphQLController extends Controller
{
    public function query(Request $request, Processor $processor)
    {
        list($queries, $isMultiQueryRequest) = $this->getPayload($request);

        $queryResponses = array_map(function($queryData) use($processor) {
            return $this->executeQuery($processor, $queryData['query'], $queryData['variables']);
        }, $queries);

        $response = new JsonResponse(
            $isMultiQueryRequest ? $queryResponses : $queryResponses[0],
            200,
            config('graphql.response.headers')
        );

        if (config('graphql.response.json_pretty')) {
             $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        }

        return $response;
    }

    protected function executeQuery($processor, $query, $variables)
    {
        $processor->processPayload($query, $variables);

        return $processor->getResponseData();
    }

    protected function getPayload(Request $request)
    {
        $query = $request->get('query', null);
        $variables = $request->get('variables', []);
        $isMultiQueryRequest = false;

        $queries = [];

        $variables = is_string($variables) ? json_decode($variables, true) ?: [] : [];

        $content = $request->getContent();
        if (! empty($content)) {
            if ($request->headers->has('Content-Type') && 'application/graphql' == $request->headers->get('Content-Type')) {
                $queries[] = [
                    'query' => $content,
                    'variables' => [],
                ];
            } else {
                $params = json_decode($content, true);
                if ($params) {
                    // check for a list of queries
                    if (isset($params[0]) === true) {
                        $isMultiQueryRequest = true;
                    } else {
                        $params = [$params];
                    }

                    foreach ($params as $queryParams) {
                        $query = isset($queryParams['query']) ? $queryParams['query'] : $query;

                        if (isset($queryParams['variables'])) {
                            if (is_string($queryParams['variables'])) {
                                $variables = json_decode($queryParams['variables'], true) ?: $variables;
                            } else {
                                $variables = $queryParams['variables'];
                            }

                            $variables = is_array($variables) ? $variables : [];
                        }

                        $queries[] = [
                            'query' => $query,
                            'variables' => $variables,
                        ];
                    }
                }
            }
        } else {
            $queries[] = [
                'query' => $query,
                'variables' => $variables,
            ];
        }

        return [$queries, $isMultiQueryRequest];
    }
}
