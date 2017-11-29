<?php

namespace GeolocationBundle\Service;

use GeolocationBundle\Entity\Location;

/*
 * Utiliza una API externa para devolver una localización
 */
abstract class AbstractGeolocation
{
    protected $serviceUrl;
    protected $serviceParameters = array();

    function __construct($service_url, $service_parameters)
    {
        $this->serviceUrl = $service_url;
        foreach ($service_parameters as $k => $v) {
            $this->serviceParameters[$k] = $v;
        }
    }

    /**
     * Compone la URL del servicio externo de geolocalización
     * @param array $params
     */
    protected function _buildUrl(array $params)
    {
        $url = $this->serviceUrl;

        $delimiter = "?";
        foreach ($params as $key => $value) {
            $url .= $delimiter.$key."=".$value;
            $delimiter = "&";
        }

        return $url;
    }

    /**
     * Ejecuta la llamada al servicio externo de geolocalización
     * @param string $latitude
     * @param string $longitude
     * @param string $accuracy
     * @return string
     */
    protected function _callGeolocationService($latitude, $longitude, $accuracy)
    {
    }

    /**
     * Devuelve la entidad Location considerada mas precisa con la información completa
     * @param string $latitude
     * @param string $longitude
     * @param string $accuracy
     * @return Location|null
     */
    public function getBestLocation($latitude, $longitude, $accuracy)
    {
    }

    /**
     * Devuelve un array de elementos Location con la información completa
     * @param string $latitude
     * @param string $longitude
     * @param string $accuracy
     * @return array
     */
    public function getAllLocations($latitude, $longitude, $accuracy)
    {
    }

}