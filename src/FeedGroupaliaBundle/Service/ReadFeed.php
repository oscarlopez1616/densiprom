<?php

namespace FeedGroupaliaBundle\Service;

use Symfony\Component\DomCrawler\Crawler;
use FeedGroupaliaBundle\Entity\LineaFeed;
use FeedGroupaliaBundle\Entity\LineaLog;

class ReadFeed {

    private $simpleXmlFeed;
    private $xmlName;
    private $flagFeedRecorrido;

    function __construct() {
        ini_set('max_execution_time', 1800);
        $this->xmlName = "feed-groupalia.xml";
        $urlFeed = "http://es.groupalia.com/feeds/es.xml";
        $remoteContent = file_get_contents($urlFeed);
        unset($urlFeed);
        file_put_contents($this->xmlName, $remoteContent);
        unset($remoteContent);
    }

    function SetDealsInFeedGroupaliaToBBDD($DoctrineEntityManager) {
        $DoctrineEntityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed')->trucateTable();
        $DoctrineEntityManager->clear();
        $simpleXmlFeed = simplexml_load_file($this->xmlName);
        $datoFeed = array();
        $j = 0;
        foreach ($simpleXmlFeed as $response) {
            $datoFeed["response"] = (string) $response->asXML();
            $datoFeed["productId"] = (int) $response->productId;
            $datoFeed["sku"] = (string) $response->sku;
            $datoFeed["title"] = (string) $response->title;
            $datoFeed["tradeName"] = (string) $response->tradeName;
            $datoFeed["shortTitle"] = (string) $response->shortTitle;
            $datoFeed["shortDescription"] = (string) $response->shortDescription;
            $datoFeed["endDate"] = (string) $response->endDate;
            $datoFeed["specialPriceInPrince"] = (string) $response->prices->specialPrice;
            $datoFeed["priceInPrince"] = (string) $response->prices->price;
            $datoFeed["discountInPrince"] = (string) $response->prices->discount;
            $datoFeed["canonicalUrl"] = (string) $response->canonicalUrl;
            $datoFeed["image"] = (string) $response->image;
            $i = 0;
            foreach ($response->attributes->attributes as $attribute) {
                if ($i == 0) {
                    $datoFeed["attributes"] = (string) $attribute[0];
                } else {
                    $datoFeed["attributes"] = $datoFeed["attributes"] . "," . (string) $attribute[0];
                }
                $i++;
            }

            $i = 0;
            foreach ($response->imageGallery as $imageGallery) {
                if ($i == 0) {
                    $datoFeed["imageGallery"] = (string) $imageGallery->image;
                } else {
                    $datoFeed["imageGallery"] = $datoFeed["imageGallery"] . "," . (string) $imageGallery->image;
                }
                $i++;
            }

            $i = 0;
            foreach ($response->storeVisibility as $storeVisibility) {
                if ($i == 0) {
                    $datoFeed["storedIdInStoreVisibility"] = (int) $storeVisibility->storeId;
                    $datoFeed["urlInStoreVisibility"] = (string) $storeVisibility->url;
                } else {
                    $datoFeed["storedIdInStoreVisibility"] = $datoFeed["storedIdInStoreVisibility"] . "," . (int) $storeVisibility->storeId;
                    $datoFeed["urlInStoreVisibility"] = $datoFeed["urlInStoreVisibility"] . "," . (string) $storeVisibility->url;
                }
                $i++;
            }
            $datoFeed["addressInGeoLocations"] = (string) $response->geoLocations->address;
            $datoFeed["latitudeInGeoLocations"] = (double) $response->geoLocations->latitude;
            $datoFeed["longitudeInGeoLocations"] = (double) $response->geoLocations->longitude;
            $datoFeed["idInfamilyAttribute"] = (int) $response->familyAttribute->id;
            $datoFeed["nameInfamilyAttribute"] = (string) $response->familyAttribute->name;
            $datoFeed["textInlocationSummary"] = (string) $response->locationSummary->text;
            $this->newArrayFeedToBBDD($datoFeed, $DoctrineEntityManager);
            if ($j % 1 == 0) {//no se puede cambiar a no ser que se retoque el catch no vale la pena para un importador
                try {
                    $DoctrineEntityManager->flush();
                    $DoctrineEntityManager->clear();
                } catch (\Exception $e) {
                    $DoctrineEntityManager = $this->reOpenEntityManagerDoctrine($DoctrineEntityManager);
                }
                $this->flagFeedRecorrido = true;
            }
            $j++;
            unset($response);
        }
        try {
            $DoctrineEntityManager->flush();
            $DoctrineEntityManager->clear();
        } catch (\Exception $e) {
            $DoctrineEntityManager = $this->reOpenEntityManagerDoctrine($DoctrineEntityManager);
        }
        $this->setLog($DoctrineEntityManager);
        unlink(urldecode($this->xmlName));
    }

    private function newArrayFeedToBBDD($datoFeed, $DoctrineEntityManager) {
        $LineaFeed = new LineaFeed();
        $LineaFeed->setResponse($datoFeed["response"]);
        $LineaFeed->setProductId($datoFeed["productId"]);
        $LineaFeed->setSku($datoFeed["sku"]);
        $LineaFeed->setTitle($datoFeed["title"]);
        $LineaFeed->setTradeName($datoFeed["tradeName"]);
        $LineaFeed->setShortTitle($datoFeed["shortTitle"]);
        $LineaFeed->setShortDescription($datoFeed["shortDescription"]);
        $LineaFeed->setEndDate($datoFeed["endDate"]);
        $LineaFeed->setSpecialPriceInPrince($datoFeed["specialPriceInPrince"]);
        $LineaFeed->setPriceInPrince($datoFeed["priceInPrince"]);
        $LineaFeed->setDiscountInPrince($datoFeed["discountInPrince"]);
        $LineaFeed->setCanonicalUrl($datoFeed["canonicalUrl"]);
        $LineaFeed->setImage($datoFeed["image"]);
        $LineaFeed->setAttributes($datoFeed["attributes"]);
        $LineaFeed->setImageGallery($datoFeed["imageGallery"]);
        $LineaFeed->setStoredIdInStoreVisibility($datoFeed["storedIdInStoreVisibility"]);
        $LineaFeed->setUrlInStoreVisibility($datoFeed["urlInStoreVisibility"]);
        $LineaFeed->setAddressInGeoLocations($datoFeed["addressInGeoLocations"]);
        $LineaFeed->setLatitudeInGeoLocations($datoFeed["latitudeInGeoLocations"]);
        $LineaFeed->setLongitudeInGeoLocations($datoFeed["longitudeInGeoLocations"]);
        $LineaFeed->setIdInfamilyAttribute($datoFeed["idInfamilyAttribute"]);
        $LineaFeed->setNameInfamilyAttribute($datoFeed["nameInfamilyAttribute"]);
        $LineaFeed->setTextInlocationSummary($datoFeed["textInlocationSummary"]);
        try {
            $DoctrineEntityManager->persist($LineaFeed);
        } catch (\Exception $e) {
            $DoctrineEntityManager = $this->reOpenEntityManagerDoctrine($DoctrineEntityManager);
        }
        unset($LineaFeed);
    }

    private function reOpenEntityManagerDoctrine($DoctrineEntityManager) {
        if (!$DoctrineEntityManager->isOpen()) {
            $DoctrineEntityManager = $DoctrineEntityManager->create(
                    $DoctrineEntityManager->getConnection(), $DoctrineEntityManager->getConfiguration()
            );
        }
        return $DoctrineEntityManager;
    }

    private function setLog($DoctrineEntityManager,$family="all") {
        $nameLineaFeed = "LineaFeed";
        if($family!="all"){
            $nameLineaFeed = $nameLineaFeed.$family;
        }
        $LineaLogArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaLog')->findBy(array('typeServicio' => $nameLineaFeed));
        if (isset($LineaLogArray[0])) {
            $DoctrineEntityManager->remove($LineaLogArray[0]);
            $DoctrineEntityManager->flush();
        }
        $LineaLog = new LineaLog();
        $LineaLog->setDatetimeUltimoServicioEjecutado(new \DateTime(date("Y-m-d H:i:s")));
        $LineaLog->setTypeServicioLineaFeed($family);
        $DoctrineEntityManager->persist($LineaLog);
        $DoctrineEntityManager->flush();
    }

    public function setInfoExtraToLineaFeed($DoctrineEntityManager) {
        //CASPAT0000316444
        $url = "http://es.groupalia.com/ofertas-viajes/cuatro-cinco-dias-toscana-hotel-vuelos-excursiones-toscana.html";
        $documentHtml = file_get_contents($url);
        $crawler = new Crawler($documentHtml);
        global  $descuento;
        $crawler->filterXPath('//span[@class="dto"]')->reduce(function (Crawler $node, $i) {
            $GLOBALS['descuento']=  $node->text();
        });
        $descuento = str_replace('%', "", $descuento);
        echo $descuento;
        global  $price;
        $crawler->filterXPath('//span[@class="price"]')->reduce(function (Crawler $node, $i) {
            $GLOBALS['price']=  $node->text();
        });
        $price = str_replace('€', "", $price);
        echo $price;
        global  $originalPrice;
        $crawler->filterXPath('//span[@class="original"]')->reduce(function (Crawler $node, $i) {
            $GLOBALS['originalPrice']=  $node->text();
        });
        $originalPrice = str_replace('€', "", $originalPrice);
        echo $originalPrice;
        $sku = "CASPAT0000316444";
        exit();
        $LineaFeed = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed')->findOneBy(array("sku" => $sku));
        $LineaFeed->setSpecialPriceInPrince($price);
        $LineaFeed->setDiscountInPrince($descuento);
        $DoctrineEntityManager->persist($LineaFeed);
    }

}
