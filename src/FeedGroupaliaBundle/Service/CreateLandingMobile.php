<?php

namespace FeedGroupaliaBundle\Service;

use Symfony\Component\DomCrawler\Crawler;
use FeedGroupaliaBundle\Entity\LineaFeed;

class CreateLandingMobile {

    private $landing;
    private $preTemplateHTML;
    private $postTemplateHTML;

    function __construct() {
        ini_set('max_execution_time', 1800);
        $this->preTemplateHTML = '<script>jQuery(".mas-vendidos-swiper > .swiper-wrapper > div").remove();';
        $this->postTemplateHTML = '';
    }

    function getLanding() {
        return $this->landing;
    }

    function setLandingBySkuArray($skuArray, $DoctrineEntityManager) {
        $this->landing = $this->preTemplateHTML;
        $LineaFeedArray = $this->getLineaFeedArrayBySkuArray($skuArray, $DoctrineEntityManager);
        if (count($LineaFeedArray) == 0)
            throw new \Exception('NoLineaFeedInCaspas');
        $i = 0;
        foreach ($LineaFeedArray as $LineaFeed) {
            $this->landing = $this->landing . $this->getDeal($LineaFeed, $i);
            $i++;
        }

        $this->postTemplateHTML = $this->postTemplateHTML . "</script>";
        $this->landing = $this->landing . $this->postTemplateHTML;
    }

    private function getDeal($LineaFeed, $i) {
        $image = $LineaFeed->getImage();
        $shortTitle = $this->cleanText($this->cortaStringLargo($LineaFeed->getShortTitle()));
        $address = $this->cleanText($this->cortaStringLargo($LineaFeed->getAddressInGeoLocations()));

        $discount = $this->cleanText($LineaFeed->getDiscountInPrince());
        if ($discount != "")
            $discount = $discount . "%dto";

        $price = $this->cleanText($LineaFeed->getPriceInPrince());
        if ($price != "")
            $price = $price . "€";

        $specialPrice = $this->cleanText($LineaFeed->getSpecialPriceInPrince());
        if ($specialPrice != "")
            $specialPrice = $specialPrice . "€";

        $sku = $LineaFeed->getSku();


        $canonicalUrl = $LineaFeed->getCanonicalUrl();
        $urlMobile = $canonicalUrl;
        preg_match('/(\.com).+/', $canonicalUrl, $coincidencias);
        preg_match('/\/.+/', $coincidencias[0], $coincidencias);
        $urlMobile = $coincidencias[0];
        $anchorBlank = "";
        $protocol = "http";

        $insertDom = 'jQuery(".swiper-wrapper").append(deal' . $i . ');';
        $dealTemp = 'var deal' . $i . ' =\'';
        $dealTemp = $dealTemp . '<div class="swiper-slide"><a href="javascript:window.location=\\\'' . $urlMobile . '\\\';"><div class="deal-box"><img class="deal-box-pestana" src="/themes/es/images/newhome/home_pestanacell.png"><img class="deal-box-pestana-attribute" src="/themes/es/images/apps/ios/directorio/'.$this->mappingIconInNameAttribute($LineaFeed->getNameInfamilyAttribute()).'" width="15"><div class="deal-box-image"><img src="' . $image . '"></div><div class="deal-box-title">' . $shortTitle . '</div><div class="deal-box-ratings"/><div class="deal-box-prices"><div class="deal-box-oldprice">' . $price . '</div><div class="deal-box-discount">' . $discount . '</div><div class="deal-box-price">' . $specialPrice . '</div></div></div></a></div>\';';
        return $dealTemp . $insertDom;
    }

    private function mappingIconInNameAttribute($inNameAttribute) {
        $pngName = "";
        switch ($inNameAttribute) {
            case "Restaurantes":
                $pngName =  "273@2x.png";
                break;
            case "Ocio":
                $pngName =  "2@2x.png";
                break;
            case "Salud y Belleza":
                $pngName =  "137@2x.png";
                break;
            case "Viajes":
                $pngName =  "339@2x.png";
                break;
            case "Shopping":
                $pngName =  "290@2x.png";
                break;
            case "Cursos":
                $pngName =  "81@2x.png";
                break;
        }
        return $pngName;
    }
    
    private function cleanText($text){
        $text = str_replace(array("'",'"'),"",$text);
        return $text;
    }

    /*
     * $SkuArray array[int] de skus array(0=>'CASPA0000321192',1=>'CASPA0000321127',2=>'CASPA0000321274',3=>'CASPA0000321496');
     */

    private function getLineaFeedArrayBySkuArray($skuArray, $DoctrineEntityManager) {
        $LineaFeedArray = array();
        $LineaFeedArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed')->findBy(array('sku' => $skuArray));
        $lineaFeedArrayTemp = array();
        foreach ($skuArray as $keySku => $sku) {
            foreach ($LineaFeedArray as $keyLineaFeed => $LineaFeed) {
                if ($sku === $LineaFeed->getSku())
                    array_push($lineaFeedArrayTemp, $LineaFeed);
            }
        }
        return $lineaFeedArrayTemp;
    }

    private function cortaStringLargo($string) {
        $string = substr($string, 0, 81);
        return $string;
    }

}
