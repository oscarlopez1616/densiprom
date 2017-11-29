<?php

namespace FeedGroupaliaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineaGoogleAdwords
 *
 * @ORM\Table(name="linea_google_adwords")
 * @ORM\Entity(repositoryClass="FeedGroupaliaBundle\Repository\LineaGoogleAdwordsRepository")
 */
class LineaGoogleAdwords {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /** @ORM\Column(length=500,nullable=false) */
    private $merchantText;
    /** @ORM\Column(type="float",nullable=false) */
    private $discountNumber;
    /** @ORM\Column(length=255,nullable=false) */
    private $startPricePrice;
    /** @ORM\Column(length=255,nullable=false) */
    private $originalPricePrice;
    /** @ORM\Column(length=255,nullable=false) */
    private $salesStartsDate;
    /** @ORM\Column(length=255,nullable=false) */
    private $saleEndsDate;
    /** @ORM\Column(length=255,nullable=false) */
    private $category;
    /** @ORM\Column(length=255,nullable=false) */
    private $subcategory;
    /** @ORM\Column(length=255,nullable=false) */
    private $concepto;
    /** @ORM\Column(length=255,nullable=false) */
    private $grupoDeAnuncios;
    /**
     * @ORM\Column(type="array")
     * @var array
     */
    private $targetKeyword;
    /** @ORM\Column(length=255,nullable=false) */
    private $action;
    /** @ORM\Column(length=255,nullable=false) */
    private $customID;
    /** @ORM\Column(length=500,nullable=true) */
    private $ciudad;
    /** @ORM\Column(length=500,nullable=true) */
    private $tituloCorto;
    /** @ORM\Column(length=255,nullable=false) */
    private $url;
    /** @ORM\Column(length=5000,nullable=true) */
    private $urlImage;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    function getMerchantText() {
        return $this->merchantText;
    }

    function getDiscountNumber() {
        return $this->discountNumber;
    }

    function getStartPricePrice() {
        return $this->startPricePrice;
    }

    function getOriginalPricePrice() {
        return $this->originalPricePrice;
    }

    function getSalesStartsDate() {
        return $this->salesStartsDate;
    }

    function getSaleEndsDate() {
        return $this->saleEndsDate;
    }

    function getCategory() {
        return $this->category;
    }

    function getSubcategory() {
        return $this->subcategory;
    }

    function getConcepto() {
        return $this->concepto;
    }

    function getGrupoDeAnuncios() {
        return $this->grupoDeAnuncios;
    }

    function getTargetKeyword() {
        return $this->targetKeyword;
    }

    function getAction() {
        return $this->action;
    }

    function getCustomID() {
        return $this->customID;
    }

    function getCiudad() {
        return $this->ciudad;
    }

    function getTituloCorto() {
        return $this->tituloCorto;
    }

    function getUrl() {
        return $this->url;
    }

    function getUrlImage() {
        return $this->urlImage;
    }

    function setMerchantText($merchantText) {
        $this->merchantText = $merchantText;
    }

    function setDiscountNumber($discountNumber) {
        $this->discountNumber = $discountNumber;
    }

    function setStartPricePrice($startPricePrice) {
        $this->startPricePrice = $startPricePrice;
    }

    function setOriginalPricePrice($originalPricePrice) {
        $this->originalPricePrice = $originalPricePrice;
    }

    function setSalesStartsDate($salesStartsDate) {
        $this->salesStartsDate = $salesStartsDate;
    }

    function setSaleEndsDate($saleEndsDate) {
        $this->saleEndsDate = $saleEndsDate;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    function setSubcategory($subcategory) {
        $this->subcategory = $subcategory;
    }

    function setConcepto($concepto) {
        $this->concepto = $concepto;
    }

    function setGrupoDeAnuncios($grupoDeAnuncios) {
        $this->grupoDeAnuncios = $grupoDeAnuncios;
    }

    function setTargetKeyword($targetKeyword) {
        $this->targetKeyword = $targetKeyword;
    }

    function setAction($action) {
        $this->action = $action;
    }

    function setCustomID($customID) {
        $this->customID = $customID;
    }

    function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    function setTituloCorto($tituloCorto) {
        $this->tituloCorto = $tituloCorto;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setUrlImage($urlImage) {
        $this->urlImage = $urlImage;
    }



}
