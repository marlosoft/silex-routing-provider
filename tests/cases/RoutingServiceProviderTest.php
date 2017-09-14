<?php

namespace Marlosoft\Tests\Silex\Routing\Annotation;

use Marlosoft\Silex\Provider\RoutingServiceProvider;
use Silex\Application;
use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ControllerTest
 * @package Marlosoft\Tests\Silex\Routing\Annotation
 */
class RoutingServiceProviderTest extends WebTestCase
{
    /**
     * @return Application
     */
    public function createApplication()
    {
        $app = new Application(['debug' => true]);
        $app->register(new RoutingServiceProvider(), [
            'routes.directories' => [__DIR__ . '/Controllers']
        ]);

        return $app;
    }

    /**
     * @return array
     */
    public function uriDataProvider()
    {
        return [
            ['/index', true, Response::HTTP_OK],
            ['/index/index', true, Response::HTTP_OK],
            ['/index/not-exists', false, Response::HTTP_NOT_FOUND]
        ];
    }

    public function methodDataProvider()
    {
        return [
            ['/post', Request::METHOD_POST, true, Response::HTTP_OK],
            ['/post', Request::METHOD_GET, false, Response::HTTP_METHOD_NOT_ALLOWED],
        ];
    }

    /**
     * @return array
     */
    public function requirementsDataProvider()
    {
        return [
            [1, true, Response::HTTP_OK],
            [99, true, Response::HTTP_OK],
            ['data', false, Response::HTTP_NOT_FOUND],
        ];
    }

    /**
     * @dataProvider uriDataProvider
     * @param string $uri
     * @param bool $isOK
     * @param int $statusCode
     */
    public function testSimpleRouting($uri, $isOK, $statusCode)
    {
        $client =  $this->createClient();
        $client->request(Request::METHOD_GET, $uri);
        $response = $client->getResponse();

        $this->assertEquals($isOK, $response->isOk());
        $this->assertEquals($statusCode, $response->getStatusCode());
    }

    /**
     * @dataProvider methodDataProvider
     * @param string $uri
     * @param string $method
     * @param bool $isOK
     * @param int $statusCode
     */
    public function testMethodRouting($uri, $method, $isOK, $statusCode)
    {
        $client =  $this->createClient();
        $client->request($method, $uri);
        $response = $client->getResponse();

        $this->assertEquals($isOK, $response->isOk());
        $this->assertEquals($statusCode, $response->getStatusCode());
    }

    /**
     * @dataProvider requirementsDataProvider
     * @param mixed $requirement
     * @param bool $isOK
     * @param int $statusCode
     */
    public function testRequirementsRouting($requirement, $isOK, $statusCode)
    {
        $client =  $this->createClient();
        $client->request(Request::METHOD_GET, '/comment/' . $requirement);
        $response = $client->getResponse();

        $this->assertEquals($isOK, $response->isOk());
        $this->assertEquals($statusCode, $response->getStatusCode());
    }
}
