<?php

namespace Tests\GeolocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\DataCollector\RequestDataCollector;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultControllerTest
 * @package GeolocationBundle\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    const AUTH_CREDENTIALS            = array('PHP_AUTH_USER' => 'carlosas','PHP_AUTH_PW' => 'asdfqwer');
    const INVALID_RESOURCE_URL        = '/api/lolwtf/1/1/1/';
    const VALID_GEOLOCATION_URL       = '/api/geolocation/1/1/1/';
    const INCOMPLETE_GEOLOCATION_URL  = '/api/geolocation/1/1/1';
    const VALID_CITY_URL              = '/api/city/1/1/1/';
    private $client;


    public function setUp()
    {
        $this->client = static::createClient();
    }


    /* *****************************************************************************************************************
     * TESTS ***********************************************************************************************************
     * ****************************************************************************************************************/

    /**
     * @dataProvider urlsProvider
     */
    public function testUrl($url, $expected)
    {
        $this->client->request(Request::METHOD_GET, $url, array(), array(), self::AUTH_CREDENTIALS);
        $this->assertSame($expected, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider credentialsProvider
     */
    public function testCredentials($credentials, $expected)
    {
        $this->client->request(Request::METHOD_GET, self::VALID_GEOLOCATION_URL, array(), array(), $credentials);
        $this->assertSame($expected, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider allowedMethodsProvider
     */
    public function testAllowedMethods($method, $expected)
    {
        $this->client->request($method, self::VALID_GEOLOCATION_URL, array(), array(), self::AUTH_CREDENTIALS);
        $this->assertSame($expected, $this->client->getResponse()->getStatusCode());
    }


    /* *****************************************************************************************************************
     * DATA PROVIDERS **************************************************************************************************
     * ****************************************************************************************************************/

    public function credentialsProvider()
    {
        return [
            [array(), Response::HTTP_UNAUTHORIZED],
            [array('PHP_AUTH_USER'=>'asdf','PHP_AUTH_PW'=>'qwer'), Response::HTTP_UNAUTHORIZED],
            [self::AUTH_CREDENTIALS, Response::HTTP_OK]
        ];
    }

    public function allowedMethodsProvider()
    {
        return [
            [Request::METHOD_GET, Response::HTTP_OK],
            [Request::METHOD_POST, Response::HTTP_METHOD_NOT_ALLOWED],
            [Request::METHOD_PUT, Response::HTTP_METHOD_NOT_ALLOWED],
            [Request::METHOD_PATCH, Response::HTTP_METHOD_NOT_ALLOWED],
            [Request::METHOD_DELETE, Response::HTTP_METHOD_NOT_ALLOWED]
        ];
    }

    public function urlsProvider()
    {
        return [
            [self::INVALID_RESOURCE_URL, Response::HTTP_NOT_FOUND],
            [self::INCOMPLETE_GEOLOCATION_URL, Response::HTTP_MOVED_PERMANENTLY],
            [self::VALID_GEOLOCATION_URL, Response::HTTP_OK],
            [self::VALID_CITY_URL, Response::HTTP_OK]
        ];
    }

}
