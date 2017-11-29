<?php

namespace FeedGroupaliaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineaSalesForce
 *
 * @ORM\Table(name="linea_sales_force")
 * @ORM\Entity(repositoryClass="FeedGroupaliaBundle\Repository\LineaSalesForceRepository")
 */
class LineaSalesForce {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(length=500,nullable=false) */
    private $PUBLICATION_DATE;

    /** @ORM\Column(length=500,nullable=false) */
    private $PRODUCTID;

    /** @ORM\Column(length=500,nullable=false) */
    private $SKU;

    /** @ORM\Column(length=500,nullable=false) */
    private $STORE_ID;

    /** @ORM\Column(length=500,nullable=false) */
    private $COUNTRY;

    /** @ORM\Column(length=500,nullable=false) */
    private $TOPDEAL;

    /** @ORM\Column(length=500,nullable=false) */
    private $INITIALDATE;

    /** @ORM\Column(length=500,nullable=false) */
    private $FINALDATE;

    /** @ORM\Column(length=500,nullable=false) */
    private $STOREVISIBILITY;

    /** @ORM\Column(length=500,nullable=false) */
    private $ALWAYS_IN_NL;

    /** @ORM\Column(length=500,nullable=false) */
    private $ORDERSORT;

    /** @ORM\Column(length=500,nullable=false) */
    private $PRODUCT_URL;

    /** @ORM\Column(length=500,nullable=false) */
    private $TITLE;

    /** @ORM\Column(length=500,nullable=false) */
    private $SHORTTITLE;

    /** @ORM\Column(length=500,nullable=false) */
    private $URLKEY;

    /** @ORM\Column(length=500,nullable=false) */
    private $DAILYDEAL;

    /** @ORM\Column(length=500,nullable=false) */
    private $STOCK;

    /** @ORM\Column(length=500,nullable=false) */
    private $IMAGE;

    /** @ORM\Column(length=500,nullable=false) */
    private $PRICE;

    /** @ORM\Column(length=500,nullable=false) */
    private $SPECIALPRICE;

    /** @ORM\Column(length=500,nullable=false) */
    private $DISCOUNT;

    /** @ORM\Column(length=500,nullable=false) */
    private $LOCALIZATION;

    /** @ORM\Column(length=500,nullable=false) */
    private $STATICMAP;

    /** @ORM\Column(length=500,nullable=false) */
    private $IMGURLSMALL;

    /** @ORM\Column(length=500,nullable=false) */
    private $IMGURLBIG;

    /** @ORM\Column(length=500,nullable=false) */
    private $IMGURLPANO;

    /** @ORM\Column(length=500,nullable=false) */
    private $ADDRESS;

    /** @ORM\Column(length=500,nullable=false) */
    private $TYPE;

    /** @ORM\Column(length=500,nullable=false) */
    private $CATEGORYID;

    /** @ORM\Column(length=500,nullable=false) */
    private $GENDER;

    /** @ORM\Column(length=500,nullable=false) */
    private $PREFERENCE_ID;

    /** @ORM\Column(length=500,nullable=false) */
    private $SOCIAL_USAGE;

    /** @ORM\Column(length=500,nullable=false) */
    private $AGE_USAGE;

    /** @ORM\Column(length=500,nullable=false) */
    private $INSIGHT_ENVIRONMENT;

    /** @ORM\Column(length=500,nullable=false) */
    private $MOMENT_OF_USE;

    /** @ORM\Column(length=500,nullable=false) */
    private $WELCOME_DEAL;

    /** @ORM\Column(length=500,nullable=false) */
    private $HIDE_PRICE;

    /** @ORM\Column(length=500,nullable=false) */
    private $TRADE_NAME;

    /** @ORM\Column(length=500,nullable=false) */
    private $LOCATION_TYPE;

    /** @ORM\Column(length=500,nullable=false) */
    private $LOCATION_TEXT;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    function getPUBLICATION_DATE() {
        return $this->PUBLICATION_DATE;
    }

    function getPRODUCTID() {
        return $this->PRODUCTID;
    }

    function getSTORE_ID() {
        return $this->STORE_ID;
    }

    function getCOUNTRY() {
        return $this->COUNTRY;
    }

    function getTOPDEAL() {
        return $this->TOPDEAL;
    }

    function getINITIALDATE() {
        return $this->INITIALDATE;
    }

    function getFINALDATE() {
        return $this->FINALDATE;
    }

    function getSTOREVISIBILITY() {
        return $this->STOREVISIBILITY;
    }

    function getALWAYS_IN_NL() {
        return $this->ALWAYS_IN_NL;
    }

    function getORDERSORT() {
        return $this->ORDERSORT;
    }

    function getPRODUCT_URL() {
        return $this->PRODUCT_URL;
    }

    function getTITLE() {
        return $this->TITLE;
    }

    function getSHORTTITLE() {
        return $this->SHORTTITLE;
    }

    function getSKU() {
        return $this->SKU;
    }

    function getURLKEY() {
        return $this->URLKEY;
    }

    function getDAILYDEAL() {
        return $this->DAILYDEAL;
    }

    function getSTOCK() {
        return $this->STOCK;
    }

    function getIMAGE() {
        return $this->IMAGE;
    }

    function getPRICE() {
        return $this->PRICE;
    }

    function getSPECIALPRICE() {
        return $this->SPECIALPRICE;
    }

    function getDISCOUNT() {
        return $this->DISCOUNT;
    }

    function getLOCALIZATION() {
        return $this->LOCALIZATION;
    }

    function getSTATICMAP() {
        return $this->STATICMAP;
    }

    function getIMGURLSMALL() {
        return $this->IMGURLSMALL;
    }

    function getIMGURLBIG() {
        return $this->IMGURLBIG;
    }

    function getIMGURLPANO() {
        return $this->IMGURLPANO;
    }

    function getADDRESS() {
        return $this->ADDRESS;
    }

    function getTYPE() {
        return $this->TYPE;
    }

    function getCATEGORYID() {
        return $this->CATEGORYID;
    }

    function getGENDER() {
        return $this->GENDER;
    }

    function getPREFERENCE_ID() {
        return $this->PREFERENCE_ID;
    }

    function getSOCIAL_USAGE() {
        return $this->SOCIAL_USAGE;
    }

    function getAGE_USAGE() {
        return $this->AGE_USAGE;
    }

    function getINSIGHT_ENVIRONMENT() {
        return $this->INSIGHT_ENVIRONMENT;
    }

    function getMOMENT_OF_USE() {
        return $this->MOMENT_OF_USE;
    }

    function getWELCOME_DEAL() {
        return $this->WELCOME_DEAL;
    }

    function getHIDE_PRICE() {
        return $this->HIDE_PRICE;
    }

    function getTRADE_NAME() {
        return $this->TRADE_NAME;
    }

    function getLOCATION_TYPE() {
        return $this->LOCATION_TYPE;
    }

    function getLOCATION_TEXT() {
        return $this->LOCATION_TEXT;
    }

    function setPUBLICATION_DATE($PUBLICATION_DATE) {
        $this->PUBLICATION_DATE = $PUBLICATION_DATE;
    }

    function setPRODUCTID($PRODUCTID) {
        $this->PRODUCTID = $PRODUCTID;
    }

    function setSTORE_ID($STORE_ID) {
        $this->STORE_ID = $STORE_ID;
    }

    function setCOUNTRY($COUNTRY) {
        $this->COUNTRY = $COUNTRY;
    }

    function setTOPDEAL($TOPDEAL) {
        $this->TOPDEAL = $TOPDEAL;
    }

    function setINITIALDATE($INITIALDATE) {
        $this->INITIALDATE = $INITIALDATE;
    }

    function setFINALDATE($FINALDATE) {
        $this->FINALDATE = $FINALDATE;
    }

    function setSTOREVISIBILITY($STOREVISIBILITY) {
        $this->STOREVISIBILITY = $STOREVISIBILITY;
    }

    function setALWAYS_IN_NL($ALWAYS_IN_NL) {
        $this->ALWAYS_IN_NL = $ALWAYS_IN_NL;
    }

    function setORDERSORT($ORDERSORT) {
        $this->ORDERSORT = $ORDERSORT;
    }

    function setPRODUCT_URL($PRODUCT_URL) {
        $this->PRODUCT_URL = $PRODUCT_URL;
    }

    function setTITLE($TITLE) {
        $this->TITLE = $TITLE;
    }

    function setSHORTTITLE($SHORTTITLE) {
        $this->SHORTTITLE = $SHORTTITLE;
    }

    function setSKU($SKU) {
        $this->SKU = $SKU;
    }

    function setURLKEY($URLKEY) {
        $this->URLKEY = $URLKEY;
    }

    function setDAILYDEAL($DAILYDEAL) {
        $this->DAILYDEAL = $DAILYDEAL;
    }

    function setSTOCK($STOCK) {
        $this->STOCK = $STOCK;
    }

    function setIMAGE($IMAGE) {
        $this->IMAGE = $IMAGE;
    }

    function setPRICE($PRICE) {
        $this->PRICE = $PRICE;
    }

    function setSPECIALPRICE($SPECIALPRICE) {
        $this->SPECIALPRICE = $SPECIALPRICE;
    }

    function setDISCOUNT($DISCOUNT) {
        $this->DISCOUNT = $DISCOUNT;
    }

    function setLOCALIZATION($LOCALIZATION) {
        $this->LOCALIZATION = $LOCALIZATION;
    }

    function setSTATICMAP($STATICMAP) {
        $this->STATICMAP = $STATICMAP;
    }

    function setIMGURLSMALL($IMGURLSMALL) {
        $this->IMGURLSMALL = $IMGURLSMALL;
    }

    function setIMGURLBIG($IMGURLBIG) {
        $this->IMGURLBIG = $IMGURLBIG;
    }

    function setIMGURLPANO($IMGURLPANO) {
        $this->IMGURLPANO = $IMGURLPANO;
    }

    function setADDRESS($ADDRESS) {
        $this->ADDRESS = $ADDRESS;
    }

    function setTYPE($TYPE) {
        $this->TYPE = $TYPE;
    }

    function setCATEGORYID($CATEGORYID) {
        $this->CATEGORYID = $CATEGORYID;
    }

    function setGENDER($GENDER) {
        $this->GENDER = $GENDER;
    }

    function setPREFERENCE_ID($PREFERENCE_ID) {
        $this->PREFERENCE_ID = $PREFERENCE_ID;
    }

    function setSOCIAL_USAGE($SOCIAL_USAGE) {
        $this->SOCIAL_USAGE = $SOCIAL_USAGE;
    }

    function setAGE_USAGE($AGE_USAGE) {
        $this->AGE_USAGE = $AGE_USAGE;
    }

    function setINSIGHT_ENVIRONMENT($INSIGHT_ENVIRONMENT) {
        $this->INSIGHT_ENVIRONMENT = $INSIGHT_ENVIRONMENT;
    }

    function setMOMENT_OF_USE($MOMENT_OF_USE) {
        $this->MOMENT_OF_USE = $MOMENT_OF_USE;
    }

    function setWELCOME_DEAL($WELCOME_DEAL) {
        $this->WELCOME_DEAL = $WELCOME_DEAL;
    }

    function setHIDE_PRICE($HIDE_PRICE) {
        $this->HIDE_PRICE = $HIDE_PRICE;
    }

    function setTRADE_NAME($TRADE_NAME) {
        $this->TRADE_NAME = $TRADE_NAME;
    }

    function setLOCATION_TYPE($LOCATION_TYPE) {
        $this->LOCATION_TYPE = $LOCATION_TYPE;
    }

    function setLOCATION_TEXT($LOCATION_TEXT) {
        $this->LOCATION_TEXT = $LOCATION_TEXT;
    }

}
