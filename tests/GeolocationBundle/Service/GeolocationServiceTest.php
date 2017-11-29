<?php

namespace Tests\GeolocationBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use GeolocationBundle\Entity\Location;

/**
 * Class GeolocationServiceTest
 * @package GeolocationBundle\Tests\Service
 */
class GeolocationServiceTest extends KernelTestCase
{
    private $container;
    private $service;
    private $isSetUpReady = false;

    /*
     * The setUp() method needs to be called from any dataProvider which needs it.
     * Both setUp and setUpBeforeClass methods are run inside the run method of the
     * PHPUnit_Framework_TestSuite class. However, data from the dataProvider is
     * calculated earlier as part of createTest function.
     */
    public function setUp()
    {
        if(!$this->isSetUpReady) {
            self::bootKernel();
            $this->container = self::$kernel->getContainer();
            $this->service = $this->container->get('geolocation.geolocation');
            self::tearDown();
            $this->isSetUpReady = true;
        }
    }


    /* *****************************************************************************************************************
     * TESTS ***********************************************************************************************************
     * ****************************************************************************************************************/

    /* public function testCompleteBestLocation()
     {
         $location = $this->service->getBestLocation(41.39551, 2.14976, 1111);
         $this->assertEquals('199', $location->getStreetNumber());
         $this->assertEquals('Carrer d\'Aribau', $location->getRoute());
         $this->assertEquals('Barcelona', $location->getLocality());
         $this->assertEquals('Barcelona', $location->getAdministrativeAreaLevel2());
         $this->assertEquals('Catalunya', $location->getAdministrativeAreaLevel1());
         $this->assertEquals('España', $location->getCountry());
         $this->assertEquals('08021', $location->getPostalCode());
     }*/

    /**
     * @dataProvider routesProvider
     */
    public function testRouteFromBestLocation($coordinates, $street)
    {
        $location = $this->service->getBestLocation($coordinates[0], $coordinates[1], $coordinates[2]);
        $this->assertContains($street, $location->getRoute(), '', true);
    }

    /**
     * @dataProvider typesProvider
     */
    public function testTypes($method, $coordinates, $assertion, $expected)
    {
        $location = $this->service->$method($coordinates[0], $coordinates[1], $coordinates[2]);
        $this->$assertion($expected, $location);
    }

    /**
     * @dataProvider coordinatesProvider
     */
    public function testCoordinates($coordinates, $expected)
    {
        $location = $this->service->getBestLocation($coordinates[0], $coordinates[1], $coordinates[2]);
        $this->assertEquals($expected, $location->getAdministrativeAreaLevel2());
    }


    /* *****************************************************************************************************************
     * DATA PROVIDERS **************************************************************************************************
     * ****************************************************************************************************************/

    public function typesProvider()
    {
        return [
            ["getBestLocation", [41.39551, 2.14976, 1111], "assertInstanceOf", Location::class],
            ["getAllLocations", [41.39551, 2.14976, 1111], "assertInternalType", "array"],
            ["getBestLocation", [1, 1, 1], "assertSame", null],
            ["getAllLocations", [1, 1, 1], "assertSame", array()]
        ];
    }

    public function coordinatesProvider()
    {
        return [
            [[37.94398, -1.16363, 1111], "Murcia"],
            [[40.413496, -3.695526, 1111], "Madrid"],
            [[41.39551, 2.14976, 1111], "Barcelona"]
        ];
    }

    public function routesProvider()
    {
        return [
            [[41.63770, -0.95185, 1111], "Super Mario Bros"],
            [[41.04605, -6.75372, 1111], "La polla"],
            [[38.03811, -1.03793, 1111], "Pajas Largas"],
            [[40.786426, -2.622746, 1111], "Cristo de la Repolla"],
            [[28.11053, -15.49467, 1111], "Follao"],
            [[36.83002, -2.45384, 1111], "Gibraltar Español"],
            [[41.63088, -4.78794, 1111], "Me falta un tornillo"],
        ];
    }

}
