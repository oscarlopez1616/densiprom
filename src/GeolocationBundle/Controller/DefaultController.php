<?php

namespace GeolocationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{

    /**
     * Normaliza, serializa y prepara una JsonResponse con la informacion dada
     * @param $data
     */
    private function _prepareJsonResponse($data)
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonResponse = new JsonResponse(json_decode($serializer->serialize($data, 'json')));
        $jsonResponse->headers->set('Access-Control-Allow-Origin', '*');

        return $jsonResponse;
    }

    /**
     * Devuelve en JSON la informacion completa de la localizacion mediante una API de geolocalización externa
     * @Route(
     *    "/api/geolocation/{latitude}/{longitude}/{accuracy}/",
     *     name="geolocation",
     *     requirements={
     *         "latitude": "^([-\+])?[0-9]{1,2}([.][0-9]{1,15})?$",
     *         "latitude": "^([-\+])?[0-9]{1,2}([.][0-9]{1,15})?$",
     *         "accuracy": "\d+",
     *     }
     * )
     * @Method("GET")
     */
    public function geolocationAction($latitude, $longitude, $accuracy)
    {
        $geolocationService = $this->container->get('geolocation.geolocation');
        $location = $geolocationService->getAllLocations($latitude, $longitude, $accuracy);

        return $this->_prepareJsonResponse($location);
    }

    /**
     * Devuelve en JSON la ciudad de la localizacion mediante una API de geolocalización externa
     * @Route(
     *    "/api/city/{latitude}/{longitude}/{accuracy}/",
     *     name="city",
     *     requirements={
     *         "latitude": "^([-\+])?[0-9]{1,2}([.][0-9]{1,15})?$",
     *         "latitude": "^([-\+])?[0-9]{1,2}([.][0-9]{1,15})?$",
     *         "accuracy": "\d+",
     *     }
     * )
     * @Method("GET")
     */
    public function cityAction($latitude, $longitude, $accuracy)
    {
        $geolocationService = $this->container->get('geolocation.geolocation');
        $location = $geolocationService->getBestLocation($latitude, $longitude, $accuracy);

        if (!is_null($location)) {
            $interpreterService = $this->container->get('geolocation.interpreter');
            $location = $interpreterService->getCompanyCityFromLocation($location);
        }

        return $this->_prepareJsonResponse($location);
    }

}