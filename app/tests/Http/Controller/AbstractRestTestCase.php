<?php

namespace App\Tests\Http\Controller;

use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractRestTestCase extends AbstractWebTestCase
{
    protected string $token;

    public function setUp()
    {
        parent::setUp();

        $this->token = self::$container->getParameter('app_token');
    }

    protected function sendPost(string $resource, array $data, array $headers = [], string $apiToken = null)
    {
        return $this->sendJSONRequest('POST', $resource, $data, $headers, $apiToken);
    }

    protected function sendPut(string $resource, array $data, array $headers = [], string $apiToken = null)
    {
        return $this->sendJSONRequest('PUT', $resource, $data, $headers, $apiToken);
    }

    protected function sendPatch(string $resource, array $data, array $headers = [], string $apiToken = null)
    {
        return $this->sendJSONRequest('PATCH', $resource, $data, $headers, $apiToken);
    }

    protected function sendGet(string $resource, array $headers = [], string $apiToken = null, array $params = [])
    {
        return $this->sendJSONRequest('GET', $resource, $params, $headers, $apiToken);
    }

    protected function sendDelete(string $resource, array $headers = [], string $apiToken = null)
    {
        return $this->sendJSONRequest('DELETE', $resource, [], $headers, $apiToken);
    }

    protected function sendJSONRequest(
        string $method,
        string $resource,
        array $data = [],
        array $headers = [],
        string $apiToken = null
    ): Response {
        $headers = array_merge([
            'CONTENT_TYPE' => 'application/json',
            'HTTP_App-Token' => $apiToken ?: '',
        ], $headers);

        $this->client->request(
            $method,
            $resource,
            $method === Request::METHOD_GET ? $data : [],
            [],
            $headers,
            ($method !== Request::METHOD_GET && $data) ? json_encode($data) : null
        );

        return $this->client->getResponse();
    }
}
