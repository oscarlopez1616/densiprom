<?php

namespace AnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use AnalyticsBundle\Service\Analytics;
use AnalyticsBundle\Service\ReadAnalyticsFromFeed;

class DefaultController extends Controller {
    
    
    /**
     * @Route("/api/getlistanalyticsorderdealengie/")
     */
    public function getListAnalyticsOrderDealEngie() {
        $ReadAnalyticsFromFeed = new ReadAnalyticsFromFeed();
        print_r($ReadAnalyticsFromFeed->getDatosAnalyticsBySku($this->get('doctrine')->getEntityManager(), 12));
        exit();
    }

    /**
     * @Route("/api/setanalyticstobbdd/")
     */
    public function setAnalyticsToBBDD() {
        $ReadAnalyticsFromFeed= new ReadAnalyticsFromFeed();
        //$ReadAnalytics->SetAnalyticsInfoFeedGroupaliaToBBDD($this->get('doctrine')->getEntityManager());
        $ReadAnalyticsFromFeed->SetAnalyticsInfoFeedGroupaliaToBBDDBatch($this->get('doctrine')->getEntityManager());
        exit();
    }

}
