<?php

namespace FeedGroupaliaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineaBi
 *
 * @ORM\Table(name="linea_bi")
 * @ORM\Entity(repositoryClass="Groupalia\FeedGroupaliaBundle\Repository\LineaVentaSourceBiRepository")
 */
class LineaVentaSourceBi {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(length=500,nullable=false) */
    private $date;

    /** @ORM\Column(type="float",nullable=false) */
    private $grossSales;
    
    /** @ORM\Column(type="float",nullable=false) */
    private $netSales;

    /** @ORM\Column(length=500,nullable=false) */
    private $sku;

    /** @ORM\Column(length=500,nullable=false) */
    private $idOrder;

    /** @ORM\Column(length=500,nullable=false) */
    private $voucherCode;

    /** @ORM\Column(type="float",nullable=false) */
    private $originalPrice;

    /** @ORM\Column(type="float",nullable=false) */
    private $price;

    /** @ORM\Column(type="float",nullable=false) */
    private $discountPercent;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    function getDate() {
        return $this->date;
    }

    function getGrossSales() {
        return $this->grossSales;
    }
    
    function getNetSales() {
        return $this->netSales;
    }

    function getSku() {
        return $this->sku;
    }

    function getIdOrder() {
        return $this->idOrder;
    }

    function getVoucherCode() {
        return $this->voucherCode;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setGrossSales($grossSales) {
        $this->grossSales = $grossSales;
    }

    function setNetSales($netSales) {
        $this->netSales = $netSales;
    }

    function setSku($sku) {
        $this->sku = $sku;
    }

    function setIdOrder($idOrder) {
        $this->idOrder = $idOrder;
    }

    function setVoucherCode($voucherCode) {
        $this->voucherCode = $voucherCode;
    }

    function getOriginalPrice() {
        return $this->originalPrice;
    }

    function getPrice() {
        return $this->price;
    }

    function getDiscountPercent() {
        return $this->discountPercent;
    }

    function setOriginalPrice($originalPrice) {
        $this->originalPrice = $originalPrice;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDiscountPercent($discountPercent) {
        $this->discountPercent = $discountPercent;
    }

}
