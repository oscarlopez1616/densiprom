<?php

namespace GeolocationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use GeolocationBundle\Entity\CitiesMap;

class LoadCities implements FixtureInterface, ContainerAwareInterface
{
    private $container;
    private $dataFixtures;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $companySlug = $this->container->getParameter('company_slug');
        $externalServiceSlug = $this->container->getParameter('geolocation.service_slug');
        $datafixtures = $this->container->getParameter('datafixtures.'.$companySlug.'.citiesmap');

        if (!is_null($datafixtures) || array_key_exists($externalServiceSlug, $datafixtures)) {
            $this->dataFixtures = $datafixtures;
        } else {
            throw new NotFoundHttpException(
                'No datafixtures parameters found for the company "'.
                $companySlug.'" and provider "'.$externalServiceSlug.'"'
            );
        }

        foreach ($this->dataFixtures[$externalServiceSlug] as $c) {
            $map = new CitiesMap();
            $map->setExternalServiceSlug($externalServiceSlug);
            $map->setCompanySlug($companySlug);
            $map->setExternalServiceArea($c['external_service_area']);
            $map->setCompanyArea($c['company_area']);
            $manager->persist($map);
            $manager->flush();
        }
    }

}