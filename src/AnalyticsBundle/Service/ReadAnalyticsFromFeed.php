<?php

namespace AnalyticsBundle\Service;

use FeedGroupaliaBundle\Entity\LineaFeed;
use AnalyticsBundle\Entity\LineaAnalytics;
use AnalyticsBundle\Entity\LineaAnalayticsDetalle;
use AnalyticsBundle\Service\Analytics;

class ReadAnalyticsFromFeed {

    private $domain;

    function __construct() {
        ini_set('max_execution_time', 7200);
        $this->domain = "http://es.groupalia.com/";
    }

    /**
     * 
     * @param type $DoctrineEntityManager
     * @param string $sku
     * @return LineaAnalytics
     */
    public function getLineaAnalyticsBySku($DoctrineEntityManager, $sku) {
        $LineaFeed = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed')->findOneBy(array("sku" => $sku));
        $LineaAnalytics = $DoctrineEntityManager->getRepository('AnalyticsBundle:LineaAnalytics')->findOneBy(array("LineaFeed" => $LineaFeed));
        unset($LineaFeed);
        return $LineaAnalytics;
    }

    /**
     * 
     * @param type $DoctrineEntityManager
     * @param type $sku
     */
    public function getDatosAnalyticsBySku($DoctrineEntityManager, $sku) {
        return $DoctrineEntityManager->getRepository('AnalyticsBundle:LineaAnalayticsDetalle')->getDatosAnalyticsByLineaAnalyticsId($sku);
    }

    function SetAnalyticsInfoFeedGroupaliaToBBDDBatch($DoctrineEntityManager, $limit = 10) {
        $LineaFeedArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed')->findAll();
        $DoctrineEntityManager->clear();
        $Analytics = new Analytics();
        $offset = 2500;
        for ($i=0;$i<count($LineaFeedArray);$i=$i+$limit) {
            $j = 0;
            $analyticsWebServiceGoogleanalytics = array();
            $LineaFeedArrayBatch = array_slice($LineaFeedArray, $offset, $limit);//array_slice: Si el array es más corto que length, solamente estarán presentes los elementos disponibles del array
            $PartialPagePathArr = array();
            foreach ($LineaFeedArrayBatch as $LineaFeedArrayBatchUnit) { 
                array_push($PartialPagePathArr, $this->getRegexForUri($this->prepareCanonicalUrlToAnalyticsService($LineaFeedArrayBatchUnit->getCanonicalUrl())) );
            }
            $responseAnalyticsArray = $Analytics->getInformeAnalyticsInfoForDealEngineV1Batch($PartialPagePathArr);
            foreach ($responseAnalyticsArray as $key => $analyticsWebServiceGoogleanalytics) {
                $LineaAnalytics = $DoctrineEntityManager->getRepository('AnalyticsBundle:LineaAnalytics')->findOneBy(array("LineaFeed" => $LineaFeedArrayBatch[$j]));
                $this->newAnalyticsInfoFeedArrayGroupaliaToBBDD($analyticsWebServiceGoogleanalytics, $LineaFeedArrayBatch[$j]->getCanonicalUrl(), $DoctrineEntityManager);
                if ($j % 10 == 0 && $j != 0) {
                    $DoctrineEntityManager->flush();
                    $DoctrineEntityManager->clear();
                }
                $j++;
            }
            $DoctrineEntityManager->flush();
            $DoctrineEntityManager->clear();
            $offset = $offset+$limit;
        }
    }

    private function newAnalyticsInfoFeedArrayGroupaliaToBBDD($analyticsWebServiceGoogleanalytics, $canonicalUrl, $DoctrineEntityManager) {
        $LineaAnalytics = $this->getLineaAnalyticsCamposSeteados(new LineaAnalytics(), $analyticsWebServiceGoogleanalytics, $canonicalUrl, $DoctrineEntityManager);
        $DoctrineEntityManager->persist($LineaAnalytics);
    }

    /**
     * 
     * @param LineaAnalytics $LineaAnalytics
     * @param mixed[] $analyticsWebServiceGoogleanalytics
     * @param string $canonicalUrl
     * @param EntityManager $DoctrineEntityManager
     * @return LineaAnalytics
     */
    private function getLineaAnalyticsCamposSeteados($LineaAnalytics, $analyticsWebServiceGoogleanalytics, $canonicalUrl, $DoctrineEntityManager) {
        $LineaAnalytics->setDateCreacionLinea(new \DateTime("now"));
        if ($LineaAnalytics->getLineaFeed() == NULL) {
            $LineaFeed = $DoctrineEntityManager->getRepository("FeedGroupaliaBundle:LineaFeed")->findOneBy(array("canonicalUrl" => $canonicalUrl));
        } else {
            $LineaFeed = $LineaAnalytics->getLineaFeed();
            $colecction = $LineaAnalytics->getLineaAnalyticsDetalles();
            foreach ($colecction as $cl) {
                $DoctrineEntityManager->remove($cl);
            }
        }
        $LineaAnalytics->setLineaFeed($LineaFeed);
        if (count($analyticsWebServiceGoogleanalytics) > 0) {
            $LineaAnalyticsDetalleArr = array();
            $LineaAnalytics->setProfileName($analyticsWebServiceGoogleanalytics["profileName"]);
            $LineaAnalytics->setFilterPage($this->getRegexForUri($this->prepareCanonicalUrlToAnalyticsService($canonicalUrl)));
            for ($i=0;$i<count($analyticsWebServiceGoogleanalytics["ga:sourceMedium"]);$i++){
                $LineaAnalyticsDetalleArr[$i] = new LineaAnalayticsDetalle();
                $LineaAnalyticsDetalleArr[$i]->setGaSourceMedium($analyticsWebServiceGoogleanalytics["ga:sourceMedium"][$i]);
                $LineaAnalyticsDetalleArr[$i]->setGaBounceRate($analyticsWebServiceGoogleanalytics["ga:bounceRate"][$i]);
                $LineaAnalyticsDetalleArr[$i]->setGaBounces($analyticsWebServiceGoogleanalytics["ga:bounces"][$i]);
                $LineaAnalyticsDetalleArr[$i]->setGaNewUsers($analyticsWebServiceGoogleanalytics["ga:newUsers"][$i]);
                $LineaAnalyticsDetalleArr[$i]->setGaUniquePageviews($analyticsWebServiceGoogleanalytics["ga:uniquePageviews"][$i]);
                $LineaAnalyticsDetalleArr[$i]->setGaUsers($analyticsWebServiceGoogleanalytics["ga:users"][$i]);
                $LineaAnalytics->addLineaAnalyticsDetalle($LineaAnalyticsDetalleArr[$i]);
                $LineaAnalyticsDetalleArr[$i]->setLineaAnalytics($LineaAnalytics);
            }
        }
        return $LineaAnalytics;
    }
    
    private function prepareCanonicalUrlToAnalyticsService($canonicalUrl) {
        preg_match_all("/[a-z\-1-9]+\.html/m", $canonicalUrl, $canonicalUrl);
        $canonicalUrl = str_replace(".html", "", $canonicalUrl[0][0]);
        return $canonicalUrl;
    }

    /**
     * Devuelve la expresion regular para comprobar con el sistema de dos niveles de groupalia
     * @param string $partialUri sin .html ejemplo para comprobar la uri a.html $partialUri=a
     * @return string
     */
    private function getRegexForUri($PartialPagePath) {
        $string = '=~^(.)+(\/.\/)*(' . $PartialPagePath . '\.html.*)$';
        return $string;
    }
    

    private function getTestDatosProxyPruebaAnalytics() {
        $datosTest = Array
            (
            "profileName" => "es.groupalia.com"
            , "ga:campaign" => Array
                (
                0 => "not set"
                , 1 => "not set"
                , 2 => "not set"
            )
            , "ga:sourceMedium" => Array
                (
                0 => "direct) / (none"
                , 1 => "google / organic"
                , 2 => "google / organic"
            )
            , "ga:keyword" => Array
                (
                0 => "not set"
                , 1 => "not provided"
                , 2 => "not provided"
            )
            , "ga:pagePath" => Array
                (
                0 => "es.groupalia.com/salud-belleza/peelings-quimicos-blue-moon.html"
                , 1 => "es.groupalia.com/salud-belleza/peelings-quimicos-blue-moon.html"
                , 2 => "m.groupalia.com/salud-belleza/peelings-quimicos-blue-moon.html"
            )
            , "ga:users" => Array
                (
                0 => 7
                , 1 => 7
                , 2 => 7
            )
            , "ga:newUsers" => Array
                (
                0 => 7
                , 1 => 0
                , 2 => 0
            )
            , "ga:bounces" => Array
                (
                0 => 7
                , 1 => 0
                , 2 => 0
            )
            , "ga:bounceRate" => Array
                (
                0 => 100.0
                , 1 => 0.0
                , 2 => 0.0
            )
            , "ga:uniquePageviews" => Array
                (
                0 => 7
                , 1 => 7
                , 2 => 7
            )
        );
        return $datosTest;
    }

}
