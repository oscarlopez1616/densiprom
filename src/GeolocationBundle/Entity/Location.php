<?php

namespace GeolocationBundle\Entity;

class Location
{
    private $streetNumber;
    private $route;
    private $locality;
    private $administrativeAreaLevel2;
    private $administrativeAreaLevel1;
    private $country;
    private $postalCode;
    private $geometryLocationType;
    private $accuracy;
    private $latitude;
    private $longitude;
    private $xmlObject;

    function __construct($geoData = array())
    {
        if (!empty($geoData)) {
            $this->setLocation($geoData);
        }
    }

    /**
     * @param array $geoData
     */
    function setLocation($geoData = array())
    {
        if (isset($geoData["streetNumber"])) $this->streetNumber = $geoData["streetNumber"];
        if (isset($geoData["route"])) $this->route = $geoData["route"];
        if (isset($geoData["locality"])) $this->locality = $geoData["locality"];
        if (isset($geoData["administrativeAreaLevel2"])) $this->administrativeAreaLevel2 = $geoData["administrativeAreaLevel2"];
        if (isset($geoData["administrativeAreaLevel1"])) $this->administrativeAreaLevel1 = $geoData["administrativeAreaLevel1"];
        if (isset($geoData["country"])) $this->country = $geoData["country"];
        if (isset($geoData["postalCode"])) $this->postalCode = $geoData["postalCode"];
        if (isset($geoData["geometryLocationType"])) $this->geometryLocationType = $geoData["geometryLocationType"];
        if (isset($geoData["accuracy"])) $this->accuracy = $geoData["accuracy"];
        if (isset($geoData["latitude"])) $this->latitude = $geoData["latitude"];
        if (isset($geoData["longitude"])) $this->longitude = $geoData["longitude"];
        if (isset($geoData["xmlObject"])) $this->xmlObject = $geoData["xmlObject"];
    }

    function getStreetNumber()
    {
        return $this->streetNumber;
    }

    function getRoute()
    {
        return $this->route;
    }

    function getLocality()
    {
        return $this->locality;
    }

    function getAdministrativeAreaLevel2()
    {
        return $this->administrativeAreaLevel2;
    }

    function getAdministrativeAreaLevel1()
    {
        return $this->administrativeAreaLevel1;
    }

    function getCountry()
    {
        return $this->country;
    }

    function getPostalCode()
    {
        return $this->postalCode;
    }

    function getGeometryLocationType()
    {
        return $this->geometryLocationType;
    }

    function getAccuracy()
    {
        return $this->accuracy;
    }

    function getLatitude()
    {
        return $this->latitude;
    }

    function getLongitude()
    {
        return $this->longitude;
    }

    function getXmlObject()
    {
        return $this->xmlObject;
    }

}
