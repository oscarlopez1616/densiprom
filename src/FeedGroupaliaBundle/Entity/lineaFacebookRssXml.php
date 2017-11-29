<?php

namespace FeedGroupaliaBundle\Entity;

class lineaFacebookRssXml {

    private $gId;
    private $gTitle;
    private $applinkIosUrl;
    private $applinkIosAppStoreId;
    private $applinkIosAppName;
    private $applinkAndroidUrl;
    private $applinkAndroidPackage;
    private $applinkAndroidAppName;
    private $applinkWindowsPhoneUrl;
    private $applinkWindowsPhoneAppId;
    private $applinkWindowsPhoneAppName;
    private $gDescription;
    private $gGoogleProductCategory;
    private $gProductType;
    private $gLink;
    private $gImageLink;
    private $gCondition;
    private $gAvailability;
    private $gPrice;
    private $gBrand;
    private $gItemGroupId;
    private $gShippingCountry;
    private $gShippingService;
    private $gShippingPrice;
    private $gCustomLabel0;

    
    function getGId() {
        return $this->gId;
    }

    function getGTitle() {
        return $this->gTitle;
    }

    function getApplinkIosUrl() {
        return $this->applinkIosUrl;
    }

    function setApplinkIosUrl($applinkIosUrl) {
        $this->applinkIosUrl = $applinkIosUrl;
    }

    function getApplinkIosAppStoreId() {
        return $this->applinkIosAppStoreId;
    }

    function getApplinkIosAppName() {
        return $this->applinkIosAppName;
    }

    function getApplinkAndroidUrl() {
        return $this->applinkAndroidUrl;
    }

    function getApplinkAndroidPackage() {
        return $this->applinkAndroidPackage;
    }

    function getApplinkAndroidAppName() {
        return $this->applinkAndroidAppName;
    }

    function getApplinkWindowsPhoneUrl() {
        return $this->applinkWindowsPhoneUrl;
    }

    function getApplinkWindowsPhoneAppId() {
        return $this->applinkWindowsPhoneAppId;
    }

    function getApplinkWindowsPhoneAppName() {
        return $this->applinkWindowsPhoneAppName;
    }

    function getGDescription() {
        return $this->gDescription;
    }

    function getGGoogleProductCategory() {
        return $this->gGoogleProductCategory;
    }

    function getGProductType() {
        return $this->gProductType;
    }

    function getGLink() {
        return $this->gLink;
    }

    function getGImageLink() {
        return $this->gImageLink;
    }

    function getGCondition() {
        return $this->gCondition;
    }

    function getGAvailability() {
        return $this->gAvailability;
    }

    function getGPrice() {
        return $this->gPrice;
    }

    function getGBrand() {
        return $this->gBrand;
    }

    function getGItemGroupId() {
        return $this->gItemGroupId;
    }

    function getGShippingCountry() {
        return $this->gShippingCountry;
    }

    function getGShippingService() {
        return $this->gShippingService;
    }

    function getGShippingPrice() {
        return $this->gShippingPrice;
    }

    function setGId($gId) {
        $this->gId = $gId;
    }

    function setGTitle($gTitle) {
        $this->gTitle = $gTitle;
    }

    function setApplinkIosAppStoreId($applinkIosAppStoreId) {
        $this->applinkIosAppStoreId = $applinkIosAppStoreId;
    }

    function setApplinkIosAppName($applinkIosAppName) {
        $this->applinkIosAppName = $applinkIosAppName;
    }

    function setApplinkAndroidUrl($applinkAndroidUrl) {
        $this->applinkAndroidUrl = $applinkAndroidUrl;
    }

    function setApplinkAndroidPackage($applinkAndroidPackage) {
        $this->applinkAndroidPackage = $applinkAndroidPackage;
    }

    function setApplinkAndroidAppName($applinkAndroidAppName) {
        $this->applinkAndroidAppName = $applinkAndroidAppName;
    }

    function setApplinkWindowsPhoneUrl($applinkWindowsPhoneUrl) {
        $this->applinkWindowsPhoneUrl = $applinkWindowsPhoneUrl;
    }

    function setApplinkWindowsPhoneAppId($applinkWindowsPhoneAppId) {
        $this->applinkWindowsPhoneAppId = $applinkWindowsPhoneAppId;
    }

    function setApplinkWindowsPhoneAppName($applinkWindowsPhoneAppName) {
        $this->applinkWindowsPhoneAppName = $applinkWindowsPhoneAppName;
    }

    function setGDescription($gDescription) {
        $this->gDescription = $gDescription;
    }

    function setGGoogleProductCategory($gGoogleProductCategory) {
        $this->gGoogleProductCategory = $gGoogleProductCategory;
    }

    function setGProductType($gGoogleProductType) {
        $this->gProductType = $gGoogleProductType;
    }

    function setGLink($gLink) {
        $this->gLink = $gLink;
    }

    function setGImageLink($gImageLink) {
        $this->gImageLink = $gImageLink;
    }

    function setGCondition($gCondition) {
        $this->gCondition = $gCondition;
    }

    function setGAvailability($gAvailability) {
        $this->gAvailability = $gAvailability;
    }

    function setGPrice($gPrice) {
        $this->gPrice = $gPrice;
    }

    function setGBrand($gBrand) {
        $this->gBrand = $gBrand;
    }

    function setGItemGroupId($gItemGroupId) {
        $this->gItemGroupId = $gItemGroupId;
    }

    function setGShippingCountry($gShippingCountry) {
        $this->gShippingCountry = $gShippingCountry;
    }

    function setGShippingService($gShippingService) {
        $this->gShippingService = $gShippingService;
    }

    function setGShippingPrice($gShippingPrice) {
        $this->gShippingPrice = $gShippingPrice;
    }
    
    function getGCustomLabel0() {
        return $this->gCustomLabel0;
    }

    function setGCustomLabel0($gCustomLabel0) {
        $this->gCustomLabel0 = $gCustomLabel0;
    }

    
    function __toString() {
        $string = "<entry>";
        $string = $string . "<g:id>" . $this->getGId() . "</g:id>";
        $string = $string . "<g:title>" . $this->xmlEscape($this->getGTitle()) . "</g:title>";
        $string = $string . '<applink property="ios_url" content="' . $this->getApplinkIosUrl() . '"/>';
        $string = $string . '<applink property="ios_app_store_id" content="' . $this->getApplinkIosAppStoreId() . '"/>';
        $string = $string . '<applink property="ios_app_name" content="' . $this->getApplinkIosAppName() . '"/>';
        $string = $string . '<applink property="android_url" content="' . $this->getApplinkAndroidUrl() . '"/>';
        $string = $string . '<applink property="android_package" content="' . $this->getApplinkAndroidPackage() . '"/>';
        $string = $string . '<applink property="android_app_name" content="' . $this->getApplinkAndroidAppName() . '"/>';
        if ($this->getApplinkWindowsPhoneAppName() != NULL && $this->getApplinkWindowsPhoneAppName() != "") {
            $string = $string . '<applink property="windows_phone_url" content="' . $this->getApplinkWindowsPhoneUrl() . '"/>';
            $string = $string . '<applink property="windows_phone_app_id" content="' . $this->getApplinkWindowsPhoneAppId() . '"/>';
            $string = $string . '<applink property="windows_phone_app_name" content="' . $this->getApplinkWindowsPhoneAppName() . '"/>';
        }
        $string = $string . "<g:description>" . $this->xmlEscape($this->getGDescription()) . "</g:description>";
        if ($this->getGGoogleProductCategory() != NULL && $this->getGGoogleProductCategory() != "")
            $string = $string . "<g:google_product_category>" . $this->xmlEscape($this->getGGoogleProductCategory()) . "</g:google_product_category>";
        if ($this->getGProductType() != NULL && $this->getGProductType() != "")
            $string = $string . "<g:product_type>" . $this->xmlEscape($this->getGProductType()) . "</g:product_type>";
        $string = $string . "<g:link>" . $this->getGLink() . "</g:link>";
        if ($this->getGImageLink() != NULL && $this->getGImageLink() != ""){
            $string = $string . "<g:image_link>" . $this->getGImageLink() . "</g:image_link>";
        }else{
            $string = $string . "<g:image_link>http://d134ij1d9dyorr.cloudfront.net/medium/8/6/20150821_095127_a06D0000015koCs_0.jpg</g:image_link>";
        }
        $string = $string . "<g:condition>" . $this->xmlEscape($this->getGCondition()) . "</g:condition>";
        $string = $string . "<g:availability>" . $this->xmlEscape($this->getGAvailability()) . "</g:availability>";
        $string = $string . "<g:price>" . $this->getGPrice() . "</g:price>";
        if ($this->getGBrand() != NULL && $this->getGBrand() != "") {
            $string = $string . "<g:brand>" . $this->xmlEscape($this->getGBrand()) . "</g:brand>";
        }else{
            $string = $string . "<g:brand>Groupalia s.l</g:brand>";
        }
        if ($this->getGItemGroupId() != NULL && $this->getGItemGroupId() != "")
            $string = $string . "<g:item_group_id>" . $this->getGItemGroupId() . "</g:item_group_id>";
        if ($this->getGShippingPrice() != NULL && $this->getGShippingPrice() != "") {
            $string = $string . "<g:shipping>";
            $string = $string . "<g:country>" . $this->getGShippingCountry() . "</g:country>";
            $string = $string . "<g:service>" . $this->getGShippingService() . "</g:service>";
            $string = $string . "<g:price>" . $this->getGShippingPrice() . "</g:price>";
            $string = $string . "</g:shipping>";
        }
        if ($this->getGCustomLabel0() != NULL && $this->getGCustomLabel0() != "")
            $string = $string . "<g:custom_label_0>" . $this->xmlEscape($this->getGCustomLabel0()) . "</g:custom_label_0>";
        $string = $string . "</entry>";
        return $string;
    }

    private function xmlEscape($string) {
        return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
    }

}



