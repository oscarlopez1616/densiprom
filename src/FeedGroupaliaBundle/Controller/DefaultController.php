<?php

namespace FeedGroupaliaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FeedGroupaliaBundle\Service\CreateMailSelligent;
use FeedGroupaliaBundle\Service\CreateLanding;
use FeedGroupaliaBundle\Service\CreateLandingMobile;
use FeedGroupaliaBundle\Service\ReadFeed;
use FeedGroupaliaBundle\Service\ReadCsvBi;
use FeedGroupaliaBundle\Service\WriteFeedFacebookRssXml;
use FeedGroupaliaBundle\Service\WriteFeedGoogleRssCsv;

class DefaultController extends Controller {

    /**
     * @Route("/api/getrssxml/")
     */
    public function getRssXml(Request $request) {
        $response = new Response();
        $DoctrineEntityManager = $this->get('doctrine')->getEntityManager();
        $LineaLogArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaLog')->findBy(array('typeServicio' => 'LineaFeed'));
        if (count($LineaLogArray) > 0) {
            $fechaIndexacionFeedGroupalia = $LineaLogArray[0]->getDatetimeUltimoServicioEjecutado();
        } else {
            return $response;
        }
        $response->setLastModified($fechaIndexacionFeedGroupalia);
        $response->setPublic();
        $response->headers->set('Content-Type', 'application/xml; charset=utf-8');
        if ($response->isNotModified($request)) {
            return $response;
        }
        $WriteFeedFacebookRssXml = new WriteFeedFacebookRssXml();
        $response->setContent($WriteFeedFacebookRssXml->getRssXml($DoctrineEntityManager));
        return $response;
    }
    
        /**
     * @Route("/api/getrssxmlretail/")
     */
    public function getRssXmlRetail(Request $request) {
        $response = new Response();
        $DoctrineEntityManager = $this->get('doctrine')->getEntityManager();
        $LineaLogArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaLog')->findBy(array('typeServicio' => 'LineaFeed'));
        if (count($LineaLogArray) > 0) {
            $fechaIndexacionFeedGroupalia = $LineaLogArray[0]->getDatetimeUltimoServicioEjecutado();
        } else {
            return $response;
        }
        $response->setLastModified($fechaIndexacionFeedGroupalia);
        $response->setPublic();
        $response->headers->set('Content-Type', 'application/xml; charset=utf-8');
        if ($response->isNotModified($request)) {
            return $response;
        }
        $WriteFeedFacebookRssXml = new WriteFeedFacebookRssXml();
        $response->setContent($WriteFeedFacebookRssXml->getRssXml($DoctrineEntityManager),"Shopping");
        return $response;
    }
    
     /**
     * @Route("/api/getrsscsv/")
     */
    public function getRssCsv(Request $request) {
        //exit("csv google display retargeting info extended");
        $response = new Response();
        $DoctrineEntityManager = $this->get('doctrine')->getEntityManager();
        $LineaLogArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaLog')->findBy(array('typeServicio' => 'LineaFeed'));
        if (count($LineaLogArray) > 0) {
            $fechaIndexacionFeedGroupalia = $LineaLogArray[0]->getDatetimeUltimoServicioEjecutado();
        } else {
            return $response;
        }

        $response->setLastModified($fechaIndexacionFeedGroupalia);
        $response->setPublic();
        $response->headers->set('Content-type: text/csv');
        if ($response->isNotModified($request)) {
            return $response;
        }
        $WriteFeedGoogleRssCsv = new WriteFeedGoogleRssCsv();
        $response->setContent($WriteFeedGoogleRssCsv->getRssCsv($DoctrineEntityManager));
        return $response;
    }

    /**
     * @Route("/api/setfeedtobbdd/")
     */
    public function SetFeedToBBDD() {
        $ReadFeed = new ReadFeed();
        $ReadFeed->SetDealsInFeedGroupaliaToBBDD($this->get('doctrine')->getEntityManager());
        exit();
    }

    /**
     * @Route("/api/setinfoextratofeddinbbdd/")
     */
    public function SetInfoExtraToFeddInBBDD() {
        $ReadFeed = new ReadFeed();
        $ReadFeed->setInfoExtraToLineaFeed($this->get('doctrine')->getEntityManager());
        exit();
    }

    /**
     * @Route("/api/setcsvbitobbdd/")
     */
    public function SetCsvBiInBBDD() {
        $ReadCsvBi = new ReadCsvBi();
        $ReadCsvBi->SetLineaBiInCsvInBiToBBDD($this->get('doctrine')->getEntityManager());
        exit();
    }

    /**
     * @Route("api/landingcreatortargetgroupalia/{caspas}")
     */
    public function LandingCreatorTargetGroupaliaAction($caspas) {
        try {
            $LandingCreator = new CreateLanding();
            $skuArray = explode(",", $caspas);
            $tempArray = array();
            $tempPartialArray = array();
            $i = 0;
            foreach ($skuArray as $key => $value) {
                if ($value == "*") {
                    $tempArray[$i] =  $tempPartialArray;
                    $tempPartialArray = array();
                    $i=$i+1;
                }else{
                    array_push($tempPartialArray, $value);
                }
            }
            $skuArray = $tempArray;
            $LandingCreator->setLandingBySkuArray($skuArray, $this->get('doctrine')->getEntityManager());
            $params = array(
                'html' => $LandingCreator->getLanding()
            );
            $response = $this->render('FeedGroupaliaBundle:Default:landing-creator.html.twig', $params);
            $response->headers->set('Content-Type', 'text/html');
            $response->headers->set('Content-Disposition', 'attachment; filename="landing-groupalia.html"');
            //return $response;
            return $this->render('FeedGroupaliaBundle:Default:landing-creator.html.twig', $params);
        } catch (\Exception $ex) {
            exit($ex->getMessage());
        }
    }

    /**
     * @Route("api/landingcreatortargetfacebook/{caspas}")
     */
    public function LandingCreatorTargetGroupaliaTargetFacebook($caspas) {
        try {
            $LandingCreator = new CreateLanding("facebook");
            $skuArray = explode(",", $caspas);
            $tempArray = array();
            $tempPartialArray = array();
            $i = 0;
            foreach ($skuArray as $key => $value) {
                if ($value == "*") {
                    $tempArray[$i] =  $tempPartialArray;
                    $tempPartialArray = array();
                    $i=$i+1;
                }else{
                    array_push($tempPartialArray, $value);
                }
            }
            $skuArray = $tempArray;
            $LandingCreator->setLandingBySkuArray($skuArray, $this->get('doctrine')->getEntityManager());
            $params = array(
                'html' => $LandingCreator->getLanding()
            );
            $response = $this->render('FeedGroupaliaBundle:Default:landing-creator.html.twig', $params);
            $response->headers->set('Content-Type', 'text/html');
            $response->headers->set('Content-Disposition', 'attachment; filename="landing-facebook.html"');
            //return $response;
            return $this->render('FeedGroupaliaBundle:Default:landing-creator.html.twig', $params);
        } catch (\Exception $ex) {
            exit($ex->getMessage());
        }
    }

    /**
     * @Route("api/mailselligentcreator/{caspas}")
     */
    public function MailSelligentCreatorAction($caspas) {
        try {
            $CreateMailSelligent = new CreateMailSelligent();
            $skuArray = explode(",", $caspas);
            $CreateMailSelligent->setMailSelligentBySkuArray($skuArray, $this->get('doctrine')->getEntityManager());
            $params = array(
                'html' => $CreateMailSelligent->getMail(),
                'mktc' => '_ESGPNLDNLNCOOTR77NEMAOTOTHR00N0OTNA',
                'google_utm' => 'utm_campaign=77&utm_content=a43b25f0-2803-11e6-b3e0-67fdb8123c20&utm_medium=email&utm_source=selligent'
            );
            $response = $this->render('FeedGroupaliaBundle:Default:mail-selligent-creator.html.twig', $params);
            $response->headers->set('Content-Type', 'text/html');
            $response->headers->set('Content-Disposition', 'attachment; filename="selligent.html"');
            return $response;
            //return $this->render('FeedGroupaliaBundle:Default:mail-selligent-creator.html.twig', $params);
        } catch (\Exception $ex) {
            exit($ex->getMessage());
        }
    }
    
    /**
     * @Route("api/landingcreatormobiletargetgroupalia/{caspas}")
     */
    public function LandingCreatorMobileTargetGroupaliaAction($caspas) {
        try {
            $LandingCreatorMobile = new CreateLandingMobile();
            $skuArray = explode(",", $caspas);
            $LandingCreatorMobile->setLandingBySkuArray($skuArray, $this->get('doctrine')->getEntityManager());
            $params = array(
                'html' => $LandingCreatorMobile->getLanding()
            );
            $response = $this->render('FeedGroupaliaBundle:Default:landing-creator.html.twig', $params);
            $response->headers->set('Content-Type', 'text/html');
            $response->headers->set('Content-Disposition', 'attachment; filename="landing-groupalia.html"');
            //return $response;
            return $this->render('FeedGroupaliaBundle:Default:landing-creator.html.twig', $params);
        } catch (\Exception $ex) {
            exit($ex->getMessage());
        }
    }

}
