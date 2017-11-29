<?php

namespace Tests\GeolocationBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use GeolocationBundle\Entity\Location;

/**
 * Class InterpreterServiceTest
 * @package GeolocationBundle\Tests\Service
 */
class InterpreterServiceTest extends KernelTestCase
{
    private $container;
    private $service;
    private $citiesMap;
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
            $this->service = $this->container->get('geolocation.interpreter');
            $company = $this->container->getParameter('company_slug');
            $external_service = $this->container->getParameter('geolocation.service_slug');
            $this->citiesMap = ($this->container->getParameter("datafixtures.{$company}.citiesmap"))[$external_service];
            self::tearDown();
            $this->isSetUpReady = true;
        }
    }


    /* *****************************************************************************************************************
     * TESTS ***********************************************************************************************************
     * ****************************************************************************************************************/

    /**
     * @dataProvider locationsProvider
     */
    public function testCompanyCityFromLocation(Location $location, $expected)
    {
        $city = $this->service->getCompanyCityFromLocation($location);
        $this->assertSame($expected, $city);
    }

    /**
     * @dataProvider undefinedLocationsProvider
     */
    public function testUndefinedCompanyCityFromLocation(Location $location)
    {
        $city = $this->service->getCompanyCityFromLocation($location);
        $this->assertNull($city);
    }


    /* *****************************************************************************************************************
     * DATA PROVIDERS **************************************************************************************************
     * ****************************************************************************************************************/

    public function locationsProvider()
    {
        $this->setUp(); // We need to load the parameters

        $return = array();
        foreach ($this->citiesMap as $area) {
            $return[] = [
                new Location(array("administrativeAreaLevel2" => $area['external_service_area'])),
                $area['company_area']
            ];
        }

        return $return;
    }

    public function undefinedLocationsProvider()
    {
        return [
            [new Location(array("administrativeAreaLevel2" => "Cartagena"))]
        ];
    }
}
