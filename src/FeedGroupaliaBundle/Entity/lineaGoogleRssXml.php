<?php

namespace FeedGroupaliaBundle\Entity;

class lineaGoogleRssXml {

    //Deal ID,Deal name,Final URL,Image URL,Subtitle,Description,Price,Sale price,Category,Contextual keywords,Address,Tracking template


    private $gId; //Deal ID, - sku
    private $gBrand; //Deal name - title
    private $gLink; //Final URL - canonical_url
    private $gImageLink; //Image URL - image
    private $gTitle; //Subtitle - trade_name
    private $gDescription; //Description - short_description
    private $gPrice; //Price - price_in_price
    private $gSalePrice; //Sale price - special_price_in_price
    private $gGoogleProductCategory; //Category -getGGoogleProductCategory
    private $gContextualKeywordsArr; //Contextual Keywords
    private $gAddress; //adress - address_in_geo_locations
    private $gTrackingTemplate; //tracking template

    function getGId() {
        return $this->gId;
    }

    function getGTitle() {
        return $this->gTitle;
    }

    function getGLink() {
        return $this->gLink;
    }

    function getGImageLink() {
        return $this->gImageLink;
    }

    function getGBrand() {
        return $this->gBrand;
    }

    function getGDescription() {
        return $this->gDescription;
    }

    function getGPrice() {
        return $this->gPrice;
    }

    function getGSalePrice() {
        return $this->gSalePrice;
    }

    function getGGoogleProductCategory() {
        return $this->gGoogleProductCategory;
    }

    function getGContextualKeywordsArr() {
        return $this->gContextualKeywordsArr;
    }

    function getGAddress() {
        return $this->gAddress;
    }

    function getGTrackingTemplate() {
        return $this->gTrackingTemplate;
    }

    function setGId($gId) {
        $this->gId = $gId;
    }

    function setGTitle($gTitle) {
        $this->gTitle = strip_tags(substr($gTitle, 0, 25));
    }

    function setGLink($gLink) {
        $this->gLink = $gLink;
    }

    function setGImageLink($gImageLink) {
        $this->gImageLink = $gImageLink;
    }

    function setGBrand($gBrand) {
        $this->gBrand =  substr($gBrand, 0, 25);
    }

    function setGDescription($gDescription) {
        $this->gDescription =  strip_tags(substr($gDescription, 0, 25));
    }

    function setGPrice($gPrice) {
        $this->gPrice = $gPrice;
    }

    function setGSalePrice($gSalePrice) {
        $this->gSalePrice = $gSalePrice;
    }

    function setGGoogleProductCategory($gGoogleProductCategory) {
        $this->gGoogleProductCategory = $gGoogleProductCategory;
    }

    function setGContextualKeywordsArr($gContextualKeywordsArr) {
        $this->gContextualKeywordsArr = $gContextualKeywordsArr;
    }

    function setGAddress($gAddress) {
        $this->gAddress = $gAddress;
    }

    function setGTrackingTemplateForRetargeting() {
        $this->gTrackingTemplate = "{lpurl}?mktc=_ESDYGOOGECPCOTRSRGENECOMMMBANOTDCPG00N0NOSPANA";
    }

    // Subtitle,Description,Price,Sale price,Category,Contextual keywords,Address,Tracking template
    function __toString() {
        $string ="";
        $string = $string . $this->getGId() . ",";
        if ($this->getGBrand() != NULL && $this->getGBrand() != "") {
            $string = $string . $this->csvEscape($this->getGBrand()) . ",";
        } else {
            $string = $string . "Groupalia,";
        }
        $string = $string . $this->getGLink() . ",";
        if ($this->getGImageLink() != NULL && $this->getGImageLink() != "") {
            $string = $string . $this->csvEscape($this->getGImageLink()). ",";
        } else {
            $string = $string . '"http://d134ij1d9dyorr.cloudfront.net/medium/8/6/20150821_095127_a06D0000015koCs_0.jpg",';
        }
        $string = $string . $this->csvEscape($this->getGTitle()) . ",";
        $string = $string . $this->csvEscape($this->getGDescription()) . ",";
        $string = $string . $this->csvEscape($this->getGPrice()) . ",";
        $string = $string . $this->csvEscape($this->getGSalePrice()) . ",";
        if ($this->getGGoogleProductCategory() != NULL && $this->getGGoogleProductCategory() != "")
            $string = $string . $this->csvEscape($this->getGGoogleProductCategory()) . ",";
        $string = $string . $this->csvEscape(implode(";", $this->gContextualKeywordsArr())) . ",";
        $string = $string . $this->csvEscape($this->gAddress()) . ",";
        $string = $string . $this->gTrackingTemplate() . ",";
        return $string;
    }

    private function csvEscape($string) {
        return '"'.str_replace(array( '',''), array('\n', '\r'), $string).'"';
    }

}
