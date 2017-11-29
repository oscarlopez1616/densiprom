<?php

namespace DensiloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DensiloBundle\Models\Documento;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/api/density-prominence-checker/")
     */
    public function indexAction() {
        $Documento = new Documento();
        $params = array(
            'totalDensidadDocumento' => $Documento->getTotalDensidadDocumento(),
            'totalPalabras1' => $Documento->getTotalPalabras1()
        );
        $tempPalabras = Array();
        $i = 0;
        foreach ($params['totalPalabras1'] as $key => $value) {
            $tempPalabras[$i]["palabra"] = $value->getStringPalabra();
            $tempPalabras[$i]["valor_densidad"] = $value->getDensidad()->getPorcentajeSobreTotalDocumentoRounded();
            $tempPalabras[$i]["num_apariciones"] = $value->getDensidad()->getNumApariciones();
            $tempPalabras[$i]["valor_prominencia"] = $value->getProminencia()->getValorProminenciaRounded();
            $tempPalabras[$i]["score"] = $value->getScore();
            $tempPalabras[$i]["posiciones_prominentes"] = $value->getProminencia()->getPosicionesPromientes();
            $i++;
        }
        foreach ($tempPalabras as $key => $row) {
            $aux[$key] = $row['score'];
        }
        array_multisort($aux, SORT_DESC, $tempPalabras);
        $params["palabras1"] = $tempPalabras;
        //return new JsonResponse($params["palabras1"]);
        return $this->render('DensiloBundle:Default:index.html.twig', $params);
    }
}
