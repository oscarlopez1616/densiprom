<?php

namespace PixelTrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PixelTrackingBundle\Entity\LineaTrack;

/**
 * LineaAnalayticsDetalle
 *
 * @ORM\Table(name="atribucion")
 * @ORM\Entity(repositoryClass="Groupalia\AnalyticsBundle\Repository\AtribucionRepository")
 */
class Atribucion {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="LineaTrack", inversedBy="atribuciones")
     * @ORM\JoinColumn(name="linea_track_id", referencedColumnName="id")
     */
    private $lineaTrack;

    /** @ORM\Column(length=500,nullable=true) */
    private $utmSource;

    /** @ORM\Column(length=500,nullable=true) */
    private $utmMedium;

    /** @ORM\Column(length=500,nullable=true) */
    private $utmContent;

    /** @ORM\Column(length=500,nullable=true) */
    private $utmCampaing;

    /** @ORM\Column(length=500,nullable=true) */
    private $mktc;

    function getUtmSource() {
        return $this->utmSource;
    }

    function getUtmMedium() {
        return $this->utmMedium;
    }

    function getUtmContent() {
        return $this->utmContent;
    }

    function getUtmCampaing() {
        return $this->utmCampaing;
    }

    function getMktc() {
        return $this->mktc;
    }

    function setUtmSource($utmSource) {
        $this->utmSource = $utmSource;
    }

    function setUtmMedium($utmMedium) {
        $this->utmMedium = $utmMedium;
    }

    function setUtmContent($utmContent) {
        $this->utmContent = $utmContent;
    }

    function setUtmCampaing($utmCampaing) {
        $this->utmCampaing = $utmCampaing;
    }

    function setMktc($mktc) {
        $this->mktc = $mktc;
    }
    function getId() {
        return $this->id;
    }

    function getLineaTrack() {
        return $this->lineaTrack;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLineaTrack($lineaTrack) {
        $this->lineaTrack = $lineaTrack;
    }


}
