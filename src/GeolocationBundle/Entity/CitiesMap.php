<?php

namespace GeolocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="geolocation_cities_map")
 */
class CitiesMap
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\Column(name="external_service_slug", type="string", length=25)
     */
    private $externalServiceSlug;

    /**
     * @ORM\Column(name="company_slug", type="string", length=25)
     */
    private $companySlug;

    /**
     * @ORM\Column(name="external_service_area", type="string", length=128)
     */
    private $externalServiceArea;

    /**
     * @ORM\Column(name="company_area", type="string", nullable=true, length=128)
     */
    private $companyArea;

    function getCompanySlug()
    {
        return $this->companySlug;
    }

    function getexternalServiceSlug()
    {
        return $this->externalServiceSlug;
    }

    function getExternalServiceArea()
    {
        return $this->externalServiceArea;
    }

    function getCompanyArea()
    {
        return $this->companyArea;
    }

    function setExternalServiceSlug($externalServiceSlug) {
        $this->externalServiceSlug = $externalServiceSlug;
    }

    function setCompanySlug($companySlug) {
        $this->companySlug = $companySlug;
    }

    function setExternalServiceArea($externalServiceArea) {
        $this->externalServiceArea = $externalServiceArea;
    }

    function setCompanyArea($companyArea) {
        $this->companyArea = $companyArea;
    }

}