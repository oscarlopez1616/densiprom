<?php

namespace AnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FeedGroupaliaBundle\Entity\LineaFeed;
use AnalyticsBundle\Entity\LineaAnalayticsDetalle;

/**
 * LineaAnalytics
 *
 * @ORM\Table(name="linea_analytics")
 * @ORM\Entity(repositoryClass="AnalyticsBundle\Repository\LineaAnalyticsRepository")
 */
class LineaAnalytics {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="FeedGroupaliaBundle\Entity\LineaFeed")
     * @ORM\JoinColumn(name="linea_feed_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $LineaFeed;

    /** @ORM\Column(type="datetime",nullable=false) */
    private $dateCreacionLinea;

    /** @ORM\Column(length=500,nullable=true) */
    private $filterPage;
    
    /** @ORM\Column(length=500,nullable=true) */
    private $profileName;

    /**
     * @ORM\OneToMany(targetEntity="LineaAnalayticsDetalle", mappedBy="lineaAnalytics",cascade={"persist", "remove"})
     */
    private $lineaAnalyticsDetalles;

    public function __construct() {
        $this->lineaAnalyticsDetalles = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @return LineaFeed
     */
    function getLineaFeed() {
        return $this->LineaFeed;
    }
    
    
    function getFilterPage() {
        return $this->filterPage;
    }

    function setFilterPage($filterPage) {
        $this->filterPage = $filterPage;
    }

        /**
     * 
     * @param LineaFeed $LineaFeed
     */
    function setLineaFeed($LineaFeed) {
        $this->LineaFeed = $LineaFeed;
    }

    function getDateCreacionLinea() {
        return $this->dateCreacionLinea;
    }

    function getProfileName() {
        return $this->profileName;
    }

    function getLineaAnalyticsDetalles() {
        return $this->lineaAnalyticsDetalles;
    }

    function setDateCreacionLinea($dateCreacionLinea) {
        $this->dateCreacionLinea = $dateCreacionLinea;
    }

    function setProfileName($profileName) {
        $this->profileName = $profileName;
    }
    
    /**
     * 
     * @param LineaAnalayticsDetalle $lineaAnalyticsDetalle
     */
    function addLineaAnalyticsDetalle($lineaAnalyticsDetalle){
        if(!(is_null($lineaAnalyticsDetalle->getGaSourceMedium()) && is_null($lineaAnalyticsDetalle->getGaUsers()) && is_null($lineaAnalyticsDetalle->getGaNewUsers()) && is_null($lineaAnalyticsDetalle->getGaBounces()) && is_null($lineaAnalyticsDetalle->getGaBounceRate()) && is_null($lineaAnalyticsDetalle->getGaUniquePageviews()))  ){
            $this->lineaAnalyticsDetalles->add($lineaAnalyticsDetalle);  
        }
    }

}
