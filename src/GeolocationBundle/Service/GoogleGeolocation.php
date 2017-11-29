<?php

namespace GeolocationBundle\Service;

use GeolocationBundle\Entity\Location;

class GoogleGeolocation extends AbstractGeolocation
{
    function __construct($service_url, $service_parameters)
    {
        parent::__construct($service_url, $service_parameters);
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
        $params = array_merge($this->serviceParameters, array('latlng'=>$latitude.",".$longitude));
        $url = $this->_buildUrl($params);

        return file_get_contents($url);
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
        $allLocations = $this->getAllLocations($latitude, $longitude, $accuracy);
        if (empty($allLocations)) {
            return null;
        }

        //Cogemos el primer result o el último de tipo ROOFTOP (el más exacto encontrado)
        $keyChosenLocation = 0;
        foreach ($allLocations as $key => $location) {
            $xml = simplexml_load_string($location->getXmlObject());
            if ('ROOFTOP' === (string)$xml->geometry->location_type) {
                $keyChosenLocation = $key;
            }
        }

        return $allLocations[$keyChosenLocation];
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
        $remoteContent = $this->_callGeolocationService($latitude, $longitude, $accuracy);
        $xml = simplexml_load_string($remoteContent);

        $locations = array();

        if ('OK' === (string)$xml->status) {

            foreach ($xml as $key => $xmlObject) {
                if ('result' == $key) {
                    $location = new Location();
                    $geoData = array();
                    foreach ($xmlObject->address_component as $component) {
                        if (is_array($component->type)) {
                            $elementType = $component->type[0];
                        } else {
                            $elementType = $component->type;
                        }
                        switch ($elementType) {
                            case 'street_number':
                                $geoData["streetNumber"] = (string)$component->long_name;
                                break;
                            case 'route':
                                $geoData["route"]= (string)$component->long_name;
                                break;
                            case 'locality':
                                $geoData["locality"] = (string)$component->long_name;
                                break;
                            case 'administrative_area_level_2':
                                $geoData["administrativeAreaLevel2"] = (string)$component->long_name;
                                break;
                            case 'administrative_area_level_1':
                                $geoData["administrativeAreaLevel1"] = (string)$component->long_name;
                                break;
                            case 'country':
                                $geoData["country"] = (string)$component->long_name;
                                break;
                            case 'postal_code':
                                $geoData["postalCode"] = (string)$component->long_name;
                                break;
                        }
                    }
                    $geoData["geometryLocationType"] = (string)$xmlObject->geometry->location_type;
                    $geoData["accuracy"] = $accuracy;
                    $geoData["latitude"] = $latitude;
                    $geoData["longitude"] = $longitude;
                    $geoData["xmlObject"] = $xmlObject->asXML();
                    $location->setLocation($geoData);

                    $locations[] = $location;
                }
            }
        }
        return $locations;

    }

}