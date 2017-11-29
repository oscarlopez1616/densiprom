<?php

namespace FeedGroupaliaBundle\Service;

use FeedGroupaliaBundle\Entity\lineaGoogleRssXml;
use FeedGroupaliaBundle\Entity\LineaFeed;
use FeedGroupaliaBundle\Repository\LineaFeedRepository;

class WriteFeedGoogleRssCsv {

    function __construct() {
        ini_set('max_execution_time', 1800);
    }

    /**
     * 
     * @param type $DoctrineEntityManager
     * @param string $family si es "Shopping" solo aparecerabn los productos de retail, pero puede ser cualquier nameInfamilyAttribute del feed 
     * @return string
     */
    public function getRssCsv($DoctrineEntityManager,$family="all") {
        if($family=="all"){
            $LineaFeedArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed')->findAll();
        }else{
            $LineaFeedArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed')->findBy(array('nameInfamilyAttribute' => $family));
        }

        $DoctrineEntityManager->clear();
        $csv = "Deal ID,Deal name,Final URL,Image URL,Subtitle,Description,Price,Sale price,Category,Contextual keywords,Address,Tracking template,Custom parameter\r\n";
        foreach ($LineaFeedArray as $key => $LineaFeed) {
            $lineaGoogleRssCsv = new lineaGoogleRssXml();
            $lineaGoogleRssCsv->setGId($LineaFeed->getSku());
            $lineaGoogleRssCsv->setGBrand($LineaFeed->getShortTitle());
            $lineaGoogleRssCsv->setGLink($LineaFeed->getCanonicalUrl());       
            $lineaGoogleRssCsv->setGImageLink($LineaFeed->getImage());
            $lineaGoogleRssCsv->setGTitle($LineaFeed->getTitle());
            $lineaGoogleRssCsv->setGDescription($LineaFeed->getShortDescription());
            $lineaGoogleRssCsv->setGPrice($LineaFeed->getPrinceInPrice());
            $lineaGoogleRssCsv->setGSalePrice($LineaFeed->getSpecialPriceInPrince());
            $lineaGoogleRssCsv->setGProductType($LineaFeed->getMappedAffilliationNameInfamilyAttribute());
            $lineaGoogleRssCsv->setGContextualKeywordsArr(array($LineaFeed->getTradeName()));
            $lineaGoogleRssCsv->setGAddress($LineaFeed->getLatitudeInGeoLocations());
            $lineaGoogleRssCsv->setGTrackingTemplateForRetargeting();
            $csv = $csv . $lineaGoogleRssCsv;
        }
        return $csv;
    }

}