<?php

namespace PixelTrackingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use PixelTrackingBundle\Entity\LineaTrack;
use PixelTrackingBundle\Entity\Atribucion;


class DefaultController extends Controller {

    /**
     * @Route("/api/settrackmedium/{price}/{orderId}/{sku}/{atribucionParam}/")
     * 
     * @param type $price
     * @param type $orderId
     * @param type $sku
     * @param type $atribucionParam es un json y urlencoded 
     *  {
            "atribucion":[
                {"utmSource":"google", "utmMedium":"adwords","utmContent":"","utmCampaing":"verano16","mktc":"_esgp"}, 
                {"utmSource":"email", "utmMedium":"newsletter Dayly","utmContent":"","utmCampaing":"verano16","mktc":"_esgp"}, 
                {"utmSource":"facebook", "utmMedium":"remarketing","utmContent":"","utmCampaing":"verano16","mktc":"_esgp"} 
            ]
        }
     * @param type $output si es true la salida es json si es false no tiene salida
     * ejemplo de link para ejecutar el controlador setTrackMedium
     * 
     * localhost/densiprom/web/app_dev.php/api/settrackmedium/12/3256/caspa1254/%7B%0A%22atribucion%22%3A%5B%0A%20%20%20%20%7B%22utmSource%22%3A%22google%22%2C%20%22utmMedium%22%3A%22adwords%22%2C%22utmContent%22%3A%22%22%2C%22utmCampaing%22%3A%22verano16%22%2C%22mktc%22%3A%22_esgp%22%7D%2C%20%0A%20%20%20%20%7B%22utmSource%22%3A%22email%22%2C%20%22utmMedium%22%3A%22newsletter%20Dayly%22%2C%22utmContent%22%3A%22%22%2C%22utmCampaing%22%3A%22verano16%22%2C%22mktc%22%3A%22_esgp%22%7D%2C%20%0A%20%20%20%20%7B%22utmSource%22%3A%22facebook%22%2C%20%22utmMedium%22%3A%22remarketing%22%2C%22utmContent%22%3A%22%22%2C%22utmCampaing%22%3A%22verano16%22%2C%22mktc%22%3A%22_esgp%22%7D%20%0A%5D%0A%7D/
     * 
     * 
     * 
     */
    public function setTrackMedium($price, $orderId, $sku, $atribucionParam,$output=false) {
        try {
            $LineaTrack = new LineaTrack();
            $LineaTrack->setPrice($price);
            $LineaTrack->setOrderId($orderId);
            $LineaTrack->setSku($sku);
            $atribucionParam = json_decode(urldecode($atribucionParam));
            $atribucionParam = $atribucionParam->atribucion;
            foreach ($atribucionParam as $key => $value) {
                $Atribucion = new Atribucion();
                $Atribucion->setUtmSource($value->utmSource);
                $Atribucion->setUtmMedium($value->utmMedium);
                $Atribucion->setUtmContent($value->utmContent);
                $Atribucion->setUtmCampaing($value->utmCampaing);
                $Atribucion->setMktc($value->mktc);
                $Atribucion->setLineaTrack($LineaTrack);
                $LineaTrack->addLineaAtribucion($Atribucion);
            }
            $DoctrineEntityManager = $this->get('doctrine')->getEntityManager();
            $DoctrineEntityManager->persist($LineaTrack);
            $DoctrineEntityManager->flush();
            return new JsonResponse(array("status"=>"sucess"));
        } catch (\Exception $exc) {
            return new JsonResponse(array("status"=>"error","error"=>$exc->getTraceAsString()));
        }
    }

}
