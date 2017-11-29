<?php

namespace FeedGroupaliaBundle\Service;

use FeedGroupaliaBundle\Entity\lineaFacebookRssXml;
use FeedGroupaliaBundle\Entity\LineaFeed;
use FeedGroupaliaBundle\Repository\LineaFeedRepository;

class WriteFeedFacebookRssXml {

    function __construct() {
        ini_set('max_execution_time', 1800);
    }

    /**
     * 
     * @param type $DoctrineEntityManager
     * @param string $family si es "Shopping" solo aparecerabn los productos de retail, pero puede ser cualquier nameInfamilyAttribute del feed 
     * @return string
     */
    public function getRssXml($DoctrineEntityManager,$family="all") {
        if($family=="all"){
            $LineaFeedArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed')->findAll();
        }else{
            $LineaFeedArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed')->findBy(array('nameInfamilyAttribute' => $family));
        }

        $DoctrineEntityManager->clear();
        $rssXML = '<?xml version="1.0"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">';
        $rssXML = $rssXML . "<title>Groupalia FeedFacebook MKT</title>";
        $rssXML = $rssXML . '<link rel="self" href="http://groupalia-mkt-test.e-fbk.com/densiprom/web/getrssxml/"/>';
        foreach ($LineaFeedArray as $key => $LineaFeed) {
            $lineaFacebookRssXml = new lineaFacebookRssXml();
            $lineaFacebookRssXml->setGId($LineaFeed->getSku());
            $lineaFacebookRssXml->setGTitle(substr($LineaFeed->getShortTitle(), 0, 99));
            $lineaFacebookRssXml->setApplinkIosUrl("groupalia://sku?id=" . $LineaFeed->getSku());
            $lineaFacebookRssXml->setApplinkIosAppStoreId("406669841");
            $lineaFacebookRssXml->setApplinkIosAppName("Groupalia - Ofertas, Descuentos y cupones");
            $lineaFacebookRssXml->setApplinkAndroidUrl("groupalia://sku?id=" . $LineaFeed->getSku());
            $lineaFacebookRssXml->setApplinkAndroidPackage("com.groupalia.groupalia");
            $lineaFacebookRssXml->setApplinkAndroidAppName("Groupalia Ofertas y Descuentos");
            $lineaFacebookRssXml->setGDescription(substr(strip_tags($LineaFeed->getShortDescription()), 0, 4999));
            $lineaFacebookRssXml->setGProductType($LineaFeed->getMappedAffilliationNameInfamilyAttribute());
            $lineaFacebookRssXml->setGCustomLabel0($LineaFeed->getNameInfamilyAttribute());
            if (is_object($gGoogleProductCategory)) {
                $gGoogleProductCategory = $gGoogleProductCategory->getLineaCategoryGoogleMerchant()->getCategoryCompletaParaFeed();
            } else {
                $gGoogleProductCategory = null;
            }
            $lineaFacebookRssXml->setGGoogleProductCategory($gGoogleProductCategory);
            $lineaFacebookRssXml->setGLink($LineaFeed->getCanonicalUrl());
            $lineaFacebookRssXml->setGImageLink($LineaFeed->getImage());
            $lineaFacebookRssXml->setGCondition("new");
            $lineaFacebookRssXml->setGAvailability('in stock');
            $lineaFacebookRssXml->setGPrice($LineaFeed->getSpecialPriceInPrince());
            $lineaFacebookRssXml->setGBrand($LineaFeed->getTradeName());
            $rssXML = $rssXML . $lineaFacebookRssXml;
        }
        $rssXML = $rssXML . "</feed>";
        return $rssXML;
    }

}