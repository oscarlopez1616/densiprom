<?php

namespace PixelTrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use PixelTrackingBundle\Entity\Atribucion;

/**
 * LineaTrack
 *
 * @ORM\Table(name="linea_track",uniqueConstraints={@ORM\UniqueConstraint(name="order_id_unique_index", columns={"order_id"})})
 * @ORM\Entity(repositoryClass="Groupalia\PixelTrackingBundle\Repository\LineaTrackRepository")
 */
class LineaTrack
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /** @ORM\Column(type="float",nullable=false) */
    private $price;
    /** @ORM\Column(length=240,nullable=false) */
    private $orderId;
    /** @ORM\Column(length=500,nullable=false) */
    private $sku;

    /**
     * @ORM\OneToMany(targetEntity="Atribucion", mappedBy="lineaTrack",cascade={"persist", "remove"})
     */
    private $atribuciones;
   
    public function __construct() {
        $this->atribuciones = new ArrayCollection();
    }
    

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    function getPrice() {
        return $this->price;
    }

    function getOrderId() {
        return $this->orderId;
    }

    function getSku() {
        return $this->sku;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setOrderId($orderId) {
        $this->orderId = $orderId;
    }

    function setSku($sku) {
        $this->sku = $sku;
    }
    function getUtm_source() {
        return $this->utm_source;
    }

    function getUtm_medium() {
        return $this->utm_medium;
    }

    function getUtm_content() {
        return $this->utm_content;
    }

    function getUtm_campaing() {
        return $this->utm_campaing;
    }

    function getMktc() {
        return $this->mktc;
    }

    function setUtm_source($utm_source) {
        $this->utm_source = $utm_source;
    }

    function setUtm_medium($utm_medium) {
        $this->utm_medium = $utm_medium;
    }

    function setUtm_content($utm_content) {
        $this->utm_content = $utm_content;
    }

    function setUtm_campaing($utm_campaing) {
        $this->utm_campaing = $utm_campaing;
    }

    function setMktc($mktc) {
        $this->mktc = $mktc;
    }

    /**
     * 
     * @return ArrayCollection
     */
    function getAtribuciones() {
        return $this->atribuciones;
    }

    /**
     * 
     * @param Atribucion $atribucion
     */
    function addLineaAtribucion($atribucion){
        $this->atribuciones->add($atribucion);
    }


}

