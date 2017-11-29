<?php

namespace AnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AnalyticsBundle\Entity\LineaAnalytics;

/**
 * LineaAnalayticsDetalle
 *
 * @ORM\Table(name="linea_analaytics_detalle")
 * @ORM\Entity(repositoryClass="AnalyticsBundle\Repository\LineaAnalayticsDetalleRepository")
 */
class LineaAnalayticsDetalle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="LineaAnalytics",inversedBy="lineaAnalyticsDetalles")
     * @ORM\JoinColumn(name="linea_analytics_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $lineaAnalytics;

    /** @ORM\Column(length=500,nullable=true) */
    private $gaSourceMedium;

    /** @ORM\Column(length=500,nullable=true) */
    private $gaUsers;

    /** @ORM\Column(length=500,nullable=true) */
    private $gaNewUsers;

    /** @ORM\Column(length=500,nullable=true) */
    private $gaBounces;

    /** @ORM\Column(length=500,nullable=true) */
    private $gaBounceRate;

    /** @ORM\Column(length=500,nullable=true) */
    private $gaUniquePageviews;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * 
     * @return LineaAnalytics
     */
    function getlineaAnalytics() {
        return $this->lineaAnalytics;
    }


    function getGaSourceMedium() {
        return $this->gaSourceMedium;
    }

    function getGaUsers() {
        return $this->gaUsers;
    }

    function getGaNewUsers() {
        return $this->gaNewUsers;
    }

    function getGaBounces() {
        return $this->gaBounces;
    }

    function getGaBounceRate() {
        return $this->gaBounceRate;
    }

    function getGaUniquePageviews() {
        return $this->gaUniquePageviews;
    }

    function setLineaAnalytics($lineaAnalytics) {
        $this->lineaAnalytics = $lineaAnalytics;
    }

    function setGaSourceMedium($gaSourceMedium) {
        $this->gaSourceMedium = $gaSourceMedium;
    }

    function setGaUsers($gaUsers) {
        $this->gaUsers = $gaUsers;
    }

    function setGaNewUsers($gaNewUsers) {
        $this->gaNewUsers = $gaNewUsers;
    }

    function setGaBounces($gaBounces) {
        $this->gaBounces = $gaBounces;
    }

    function setGaBounceRate($gaBounceRate) {
        $this->gaBounceRate = $gaBounceRate;
    }

    function setGaUniquePageviews($gaUniquePageviews) {
        $this->gaUniquePageviews = $gaUniquePageviews;
    }


    
}