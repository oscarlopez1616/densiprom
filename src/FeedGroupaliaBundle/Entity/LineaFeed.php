<?php

namespace FeedGroupaliaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineaFeed
 *
 * @ORM\Table(name="linea_feed",uniqueConstraints={@ORM\UniqueConstraint(name="sku_unique_index", columns={"sku"}),@ORM\UniqueConstraint(name="canonical_url_unique_index", columns={"canonical_url"})})
 * @ORM\Entity(repositoryClass="FeedGroupaliaBundle\Repository\LineaFeedRepository")
 */
class LineaFeed {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(length=500,nullable=false) */
    private $productId;

    /** @ORM\Column(length=255,nullable=false) */
    private $sku;

    /** @ORM\Column(length=500,nullable=true) */
    private $title;

    /** @ORM\Column(length=500,nullable=true) */
    private $tradeName;

    /** @ORM\Column(length=500,nullable=true) */
    private $shortTitle;

    /** @ORM\Column(type="text",nullable=true) */
    private $shortDescription;

    /** @ORM\Column(length=500,nullable=true) */
    private $endDate;

    /** @ORM\Column(length=500,nullable=true) */
    private $specialPriceInPrince;

    /** @ORM\Column(length=500,nullable=true) */
    private $priceInPrince;

    /** @ORM\Column(length=500,nullable=true) */
    private $discountInPrince;

    /** @ORM\Column(length=253,nullable=true) */
    private $canonicalUrl;

    /** @ORM\Column(length=500,nullable=true) */
    private $image;

    /** @ORM\Column(type="text",nullable=true) */
    private $attributes;

    /** @ORM\Column(type="text",nullable=true) */
    private $imageGallery;

    /** @ORM\Column(length=500,nullable=true) */
    private $storedIdInStoreVisibility;

    /** @ORM\Column(length=5000,nullable=true) */
    private $urlInStoreVisibility;

    /** @ORM\Column(length=500,nullable=true) */
    private $addressInGeoLocations;

    /** @ORM\Column(length=500,nullable=true) */
    private $latitudeInGeoLocations;

    /** @ORM\Column(length=500,nullable=true) */
    private $longitudeInGeoLocations;

    /** @ORM\Column(type="integer",nullable=false) */
    private $idInfamilyAttribute;

    /** @ORM\Column(length=500,nullable=true) */
    private $nameInfamilyAttribute;

    /** @ORM\Column(length=500,nullable=true) */
    private $textInlocationSummary;

    /** @ORM\Column(type="text",nullable=true) */
    private $response;
    

    function getId() {
        return $this->id;
    }

    function getProductId() {
        return $this->productId;
    }

    function getSku() {
        return $this->sku;
    }

    function getTitle() {
        return $this->title;
    }

    function getTradeName() {
        return $this->tradeName;
    }

    function getShortTitle() {
        return $this->shortTitle;
    }

    function getShortDescription() {
        return $this->shortDescription;
    }

    function getEndDate() {
        return $this->endDate;
    }

    function getSpecialPriceInPrince() {
        return $this->specialPriceInPrince;
    }

    function getPriceInPrince() {
        return $this->priceInPrince;
    }

    function getDiscountInPrince() {
        return $this->discountInPrince;
    }

    function getCanonicalUrl() {
        return $this->canonicalUrl;
    }

    function getImage() {
        return $this->image;
    }

    function getAttributes() {
        return $this->attributes;
    }

    function getImageGallery() {
        return $this->imageGallery;
    }

    function getStoredIdInStoreVisibility() {
        return $this->storedIdInStoreVisibility;
    }

    function getUrlInStoreVisibility() {
        return $this->urlInStoreVisibility;
    }

    function getAddressInGeoLocations() {
        return $this->addressInGeoLocations;
    }

    function getLatitudeInGeoLocations() {
        return $this->latitudeInGeoLocations;
    }

    function getLongitudeInGeoLocations() {
        return $this->longitudeInGeoLocations;
    }

    function getIdInfamilyAttribute() {
        return $this->idInfamilyAttribute;
    }

    function getNameInfamilyAttribute() {
        return $this->nameInfamilyAttribute;
    }

    function getMappedAffilliationNameInfamilyAttribute() {
        $mappedAffiliationNameInFamily = "";
        switch ($this->nameInfamilyAttribute) {
            case 'Viajes':
                $mappedAffiliationNameInFamily = "Weekends&Travel";
                break;
            case 'Shopping':
                $mappedAffiliationNameInFamily = "Retail";
                break;
            case 'Restaurantes':
                $mappedAffiliationNameInFamily = "Restaurants&Nightlife";
                break;
            case 'Salud y Belleza':
                $mappedAffiliationNameInFamily = "Health&Beauty";
                break;
            case 'Cursos':
                $mappedAffiliationNameInFamily = "Other services";
                break;
            case 'Ocio':
                $mappedAffiliationNameInFamily = "Activities&Adventure";
                break;
            case '':
                $mappedAffiliationNameInFamily = "Other services";
                break;
        }
        return $mappedAffiliationNameInFamily;
    }

    function getTextInlocationSummary() {
        return $this->textInlocationSummary;
    }

    function getResponse() {
        return $this->response;
    }

    function setProductId($productId) {
        $this->productId = $productId;
    }

    function setSku($sku) {
        $this->sku = $sku;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setTradeName($tradeName) {
        $this->tradeName = $tradeName;
    }

    function setShortTitle($shortTitle) {
        $this->shortTitle = $shortTitle;
    }

    function setShortDescription($shortDescription) {
        $this->shortDescription = $shortDescription;
    }

    function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    function setSpecialPriceInPrince($specialPriceInPrince) {
        $this->specialPriceInPrince = $specialPriceInPrince;
    }

    function setPriceInPrince($priceInPrince) {
        $this->priceInPrince = $priceInPrince;
    }

    function setDiscountInPrince($discountInPrince) {
        $this->discountInPrince = $discountInPrince;
    }

    function setCanonicalUrl($canonicalUrl) {
        $this->canonicalUrl = $canonicalUrl;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setAttributes($attributes) {
        $this->attributes = $attributes;
    }

    function setImageGallery($imageGallery) {
        $this->imageGallery = $imageGallery;
    }

    function setStoredIdInStoreVisibility($storedIdInStoreVisibility) {
        $this->storedIdInStoreVisibility = $storedIdInStoreVisibility;
    }

    function setUrlInStoreVisibility($urlInStoreVisibility) {
        $this->urlInStoreVisibility = $urlInStoreVisibility;
    }

    function setAddressInGeoLocations($addressInGeoLocations) {
        $this->addressInGeoLocations = $addressInGeoLocations;
    }

    function setLatitudeInGeoLocations($latitudeInGeoLocations) {
        $this->latitudeInGeoLocations = $latitudeInGeoLocations;
    }

    function setLongitudeInGeoLocations($longitudeInGeoLocations) {
        $this->longitudeInGeoLocations = $longitudeInGeoLocations;
    }

    function setIdInfamilyAttribute($idInfamilyAttribute) {
        $this->idInfamilyAttribute = $idInfamilyAttribute;
    }

    function setNameInfamilyAttribute($nameInfamilyAttribute) {
        $this->nameInfamilyAttribute = $nameInfamilyAttribute;
    }

    function setTextInlocationSummary($textInlocationSummary) {
        $this->textInlocationSummary = $textInlocationSummary;
    }

    function setResponse($response) {
        $this->response = $response;
    }

}
