<?php

namespace GeolocationBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use GeolocationBundle\Entity\Location;

/*
 * Traduce la información recogida del servicio de geolocalización a localizaciones aceptadas por la compañía
 */
class Interpreter
{
    private $em;
    private $isocode;
    private $searchMethods;
    private $citiesMap;

    function __construct(EntityManager $entityManager, $companySlug, $externalServiceSlug)
    {
        $this->isocode = 'ES';
        $this->searchMethods = array ('getLocality', 'getAdministrativeAreaLevel2', 'getAdministrativeAreaLevel1');

        $this->em = $entityManager;
        $mappedCities = $this->em->getRepository('GeolocationBundle:CitiesMap')->findBy(
            array(
                'companySlug' => $companySlug,
                'externalServiceSlug' => $externalServiceSlug
            )
        );
        if (!$mappedCities) {
            throw new NotFoundHttpException(
                'No cities found for company "'.$companySlug.'" and external service "'.$externalServiceSlug.'"'
            );
        }

        $this->citiesMap = array();
        foreach ($mappedCities as $map) {
            $this->citiesMap[$map->getExternalServiceArea()] = $map->getCompanyArea();
        }
    }

    /**
     * Recorre el array de objetos Location hasta encontrar una ciudad/provincia existente en la compañía
     * @param array
     * @return string
     */
    public function getCompanyCityFromArray(array $locations)
    {
        foreach ($locations as $location) {
            if ($location instanceof Location) {
                $result = $this->getCompanyCityFromLocation($location);
                if (in_array($result, $this->citiesMap)) {
                    return $result;
                }
            }
        }

        return null;
    }

    /**
     * Recorre el objeto Location hasta encontrar una ciudad/provincia existente en la compañía
     * @param Location $latitude
     * @return string
     */
    public function getCompanyCityFromLocation(Location $location)
    {
        $normalizedCities = array();
        foreach ($this->citiesMap as $externalServiceCity => $companyCity) {
            $key = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $externalServiceCity);
            $value = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $companyCity);
            $normalizedCities[$key] = $value;
        }

        foreach ($this->searchMethods as $method) {
            $normalizedExternalServiceCity = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $location->$method());

//            if (array_key_exists($normalizedexternalServiceCity, $normalizedCities) && (null != $normalizedCities[$normalizedexternalServiceCity])) {
            if (array_key_exists($normalizedExternalServiceCity, $normalizedCities)) {
                return $this->citiesMap[$location->$method()];
            }
        }

        return null;

    }

}