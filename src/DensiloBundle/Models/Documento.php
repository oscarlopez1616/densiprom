<?php

namespace DensiloBundle\Models;

use Symfony\Component\DomCrawler\Crawler;

class Documento {

    private $crawler;
    private $countNodosPaginaPosicionables;
    private $punteroNodoPosicion;
    private $countNodosInparteSuperior;
    private $countNodosInParteMedia;
    private $countNodosInParteInferior;
    private $posicionPalabraEnDocumento;
    private $palabraActual;
    private $url;

    /**
     *
     * @var string
     */
    private $documentHtml;
    private $documentoArregloProminencia;
    private $documentoArreglo;

    /**
     *
     * @var string[]
     */
    private $documentoPalabras;

    /**
     *
     * @var string[]
     */
    private $documentoPalabrasUnique;

    /**
     *
     * @var string[] 
     */
    private $stopWordsCastellano;
    private $totalDensidadDocumento;

    /**
     *
     * @var Palabra[] 
     */
    private $totalPalabras1;

    /**
     *
     * @var Palabra[] 
     */
    private $totalPalabras2;

    /**
     *
     * @var Palabra[] 
     */
    private $totalPalabras3;

    /**
     *
     * @var Palabra[] 
     */
    private $totalPalabras4;

    /**
     *
     * @var Palabra[] 
     */
    private $totalPalabras5;

    /**
     *
     * @var Palabra[] 
     */
    private $totalPalabras6;

    function __construct() {
        //$this->url = 'http://localhost/ejemplo/index.html';
        //$this->url = 'http://example.com';
        //$this->url = 'http://www.eventos-barcelona.com/eventos/eventos-y-ferias/3822-women-talent-seminar-en-barcelona';
        $this->url = 'http://es.groupalia.com/ocio/entrada-museo-ilusiones-opticas-para-2-personas-mds.html';
        //$this->url= 'https://www.atrapalo.com/restaurantes/hotel-casa-fuster-restaurante-galaxo_f1431.html';
        $this->documentHtml = file_get_contents($this->url);
        $this->totalDensidadDocumento = 0;
        $this->countNodosPaginaPosicionables = 0;
        $this->flagNodosContados = false;
        $this->punteroNodoPosicion = 0;
        $this->crawler = new Crawler($this->documentHtml);
        $this->setCountNodosPaginaPosicionables();
        $this->setStopWordsCastellano();
        $this->setDocumentoPalabras();
    }

    function setDocumentoPalabras() {
        $this->setDocumentoArregloProminencia();
        $this->setDocumentoArreglo(); //primero prominencia porque es el que rellena el img
//        print_r($this->documentoArreglo);
//        print_r($this->documentoArregloProminencia);
//        exit();
        $textoDom = $this->getTextoInArreglo($this->documentoArreglo);
        $count = preg_match_all('/(\w|\d)+/ms', $textoDom, $coincidencias);
        $this->documentoPalabras = $coincidencias[0];
        $this->documentoPalabras = array_diff($this->documentoPalabras, $this->stopWordsCastellano);
        foreach ($this->documentoPalabras as $key => $value) {
            if ($value === "")
                unset($this->documentoPalabras[$key]);
        }

        $this->documentoPalabras = array_values($this->documentoPalabras);
        $this->documentoPalabrasUnique = array_values(array_unique($this->documentoPalabras));
        $this->setPalabras1();
    }
    

    /**
     * @param type $node
     */
    private function extractTextoNodo($node) {
        $texto = $this->eliminaCdatas(strtolower($node->html()));
        $patrón = "/<script.*?>.*?<\/script>/ms";
        $texto = preg_replace($patrón, '', $texto);
        $patrón = "/<.*?>|<\/.*?>/ms";
        $texto = preg_replace($patrón, '', $texto);
        $tempArr = array();
        $count = preg_match_all('/(\w|\d)+/ms', $texto, $coincidencias);
        $coincidencias = $coincidencias[0];
        foreach ($coincidencias as $key2 => $value2) {
            if (strlen($value2) > 2) {//si no es una letra o una stop word
                if (isset($tempArr[$key])) {
                    $tempArr[$key] = $tempArr[$key] . " " . $value2;
                } else {

                    $tempArr[$key] = $value2;
                }
            }
        }
        $texto = implode(" ", $tempArr);
        return $texto;
    }

    private function setDocumentoArreglo() {
        $this->documentoArreglo = Array();
        //echo $this->crawler->filter('body')->children()->count();
        //echo $this->crawler->filter('body')->children()->eq(1)->html();
        //echo $this->crawler->filter('body')->html();
        //exit();
        
        $this->documentoArreglo[todo] =$this->extractTextoNodo($this->crawler->filter('body')); 
        
        $this->documentoArreglo["host_uri"] = $this->documentoArregloProminencia['host_uri'];
        $this->documentoArreglo["uri"] = $this->documentoArregloProminencia['uri'];
        $this->documentoArreglo["title"] = $this->documentoArregloProminencia['title'];
        $this->documentoArreglo["meta_keywords"] = $this->documentoArregloProminencia['meta_keywords'];
        $this->documentoArreglo["meta_description"] = $this->documentoArregloProminencia['meta_description'];
        if (!isset($this->documentoArreglo))
            $this->documentoArreglo = array();
    }

    private function setDocumentoArregloProminencia() {
        $parseUrl = parse_url($this->url);
        $this->documentoArregloProminencia["host_uri"] = strtolower(str_replace("-", " ", str_replace(array("com.","es.","www.", ".com", ".es", ".cat", ".net", ".org", ".info"), "", $parseUrl["host"])));
        $this->documentoArregloProminencia["uri"] = strtolower(str_replace(array("/", "-"), " ", $parseUrl["path"]));
        $this->documentoArregloProminencia["uri"] = str_replace(array(".html", ".php"), " ", $this->documentoArregloProminencia["uri"]);
        $nodeValues = $this->crawler->filterXpath('//head/*')->filter('*')->each(function (Crawler $node, $i) {
            if ($node->nodeName() === "title")
                $this->documentoArregloProminencia[$node->nodeName()] = strtolower($node->text());
            if ($node->nodeName() === "meta") {

                if (($node->attr('name') == "keywords") || ($node->attr('name') == "description")) {
                    $this->documentoArregloProminencia[$node->nodeName() . "_" . $node->attr('name')] = strtolower($node->attr('content'));
                }
            }
        });

        $nodeValues = $this->crawler->filterXpath('//body/*')->filter('img,h1,h2,h3,h4,h5,h6,li,a,strong,b,i,italic')->each(function (Crawler $node, $i) {

            if ($node->nodeName() == "img") {
                try {
                    if ($node->attr('alt') != NULL)
                        $this->documentoArregloProminencia['ialt'] = $this->documentoArregloProminencia['ialt'] . " " . strtolower($node->attr('alt'));
                } catch (\Exception $e) {
                    if ($node->attr('alt') != NULL)
                        $this->documentoArregloProminencia['ialt'] = strtolower($node->attr('alt'));
                }
            } else {
                try {

                    $this->documentoArregloProminencia[$node->nodeName()] = $this->documentoArregloProminencia[$node->nodeName()] . " " . strtolower($this->extractTextoNodo($node));
                } catch (\Exception $e) {
                    $this->documentoArregloProminencia[$node->nodeName()] = strtolower($this->extractTextoNodo($node));
                }
            }
        });
        if (!isset($this->documentoArregloProminencia))
            $this->documentoArregloProminencia = array();
    }

    /**
     * Deja todo el texto documentoArreglo en un string
     * @return string
     */
    private function getTextoInArreglo($documentoArreglo) {
        return implode(" ", $documentoArreglo);
    }

    /**
     * eliminará los indices donde no haya ninguna palabra de $this->documentoArreglo y los tabuladores.
     */
    /* private function limpiaDocumentoArreglo($documentoArreglo) {
      $tempArr = array();
      foreach ($documentoArreglo as $key => $value) {
      $count = preg_match_all('/(\w|\d)+/ms', $value, $coincidencias);
      $coincidencias = $coincidencias[0];
      foreach ($coincidencias as $key2 => $value2) {
      if (strlen($value2) > 2) {//si no es una letra o una stop word
      if (isset($tempArr[$key])) {
      $tempArr[$key] = $tempArr[$key] . " " . $value2;
      } else {

      $tempArr[$key] = $value2;
      }
      }
      }
      }
      return $tempArr;
      } */

    private function eliminaCdatas($htmlTexto) {
        $texto = '';
        $patrón = "/\/\/<!\[cdata\[.*?\/\/\]\]>/ms"; // eliminar cdatas
        $texto = preg_replace($patrón, "", $htmlTexto);
        $tempArr[$key] = $texto;
        return $texto;
    }

    function setPalabras1() {
        $i = 0;
        foreach ($this->documentoPalabrasUnique as $key => $value) {
            $Densidad = new Densidad($value, $this->documentoArreglo, $this->documentoPalabras, $this->documentoPalabrasUnique);
            //$posicionPalabraEnDocumento = $this->getCalculaPosicionPalabraEnDocumentoConPosicionesInNodo($value);
            $posicionPalabraEnDocumento = "posicion_superior_media_inferior";
            $Prominencia = new Prominencia($value, $this->documentoArregloProminencia, $this->documentoPalabras, $this->documentoPalabrasUnique, $Densidad->getNumApariciones(), $posicionPalabraEnDocumento);
            if ($Prominencia->getValorProminencia() > 0 && $Densidad->getNumApariciones() > 1) {
                $this->totalPalabras1[$i] = new Palabra($value, $Densidad, $Prominencia);
                $this->totalDensidadDocumento = $this->totalDensidadDocumento + $this->totalPalabras1[$i]->getDensidad()->getPorcentajeSobreTotalDocumento();
                $i = $i + 1;
            }
        }
    }
    
    private function estaPalabraEnString($textoString, $palabra) {
        $flag = false;
        $palabras = explode(" ", $textoString);
        foreach ($palabras as $key => $value) {
            if ($value == $palabra) {
                $flag = true;
                break;
            } else {
                $flag = false;
            }
        }
        return $flag;
    }



    function getTotalPalabras1() {
        return $this->totalPalabras1;
    }

    function getTotalDensidadDocumento() {
        return $this->totalDensidadDocumento;
    }
    
    /**
     * Calcula la posicion de la palabra en el documento, existen las siguientes posiciones:
      case "posicion_superior_media"
      case "posicion_superior_media_inferior"
      case "posicion_superior_inferior"
      case "posicion_media_inferior"
      case "posicion_superior"
      case "posicion_media"
      case "posicion_inferior"
     * @param string
     * @return array 
     */
    private function getCalculaPosicionPalabraEnDocumentoConPosicionesInNodo($palabra) {
        $this->posicionPalabraEnDocumento = array("posicion_superior" => false, "posicion_media" => false, "posicion_inferior" => false);
        $this->palabraActual = $palabra;
        $nodeValues = $this->crawler->filterXpath('//body/*')->filter('*')->each(function (Crawler $node, $i) {
            if (($node->nodeName() != "script") && ($node->nodeName() != "iframe") && ($node->nodeName() != "noscript")) {
                if ($this->estaPalabraEnString($this->extractTextoNodo($node), strtolower($this->palabraActual))) {
                    if ($node->attr('data-posicion') == 'superior') {//PosicionSuperior
                        $this->posicionPalabraEnDocumento["posicion_superior"] = true;
                    } else if ($node->attr('data-posicion') == 'media') {//PosicionMedia
                        $this->posicionPalabraEnDocumento["posicion_media"] = true;
                    } else if ($node->attr('data-posicion') == 'inferior') {//PosicionInferior
                        $this->posicionPalabraEnDocumento["posicion_inferior"] = true;
                    }
                }
            }
        });

        if ($this->posicionPalabraEnDocumento["posicion_superior"]) {
            $posicion = "_superior";
        }
        if ($this->posicionPalabraEnDocumento["posicion_media"]) {
            if (isset($posicion)) {
                $posicion = $posicion . "_media";
            } else {
                $posicion = "_media";
            }
        }
        if ($this->posicionPalabraEnDocumento["posicion_inferior"]) {
            if (isset($posicion)) {
                $posicion = $posicion . "_superior_media";
            } else {
                $posicion = "_inferior";
            }
        }

        $posicion = "posicion" . $posicion;
        return $posicion;
    }

    /**
     * Calcula la posicion de la palabra en el documento, existen las siguientes posiciones:
      case "posicion_superior_media"
      case "posicion_superior_media_inferior"
      case "posicion_superior_inferior"
      case "posicion_media_inferior"
      case "posicion_superior"
      case "posicion_media"
      case "posicion_inferior"
     * lo contabilizaremos con un array 
     * $posicionPalabraEnDocumento = array("posicion_superior"=>false,"posicion_media"=>false,"posicion_inferior"=>false)
     * Condiciones para encontrar las posiciones
     * Parte Superior 0>= $posParteSuperior <$countNodosInparteSuperior
     * Parte Media $countNodosInparteSuperior>= $posParteMedia <$countNodosInparteSuperior+$countNodosInParteMedia
     * Parte Inferior $countNodosInparteSuperior+$countNodosInParteMedia>= $posParteMedia < $this->countNodosPaginaPosicionables   
     * @param string
     * @return array 
     */
    private function getCalculaPosicionPalabraEnDocumento($palabra) {
        $nodosPorPosicion = floor($this->countNodosPaginaPosicionables / 3);
        $moduloParteComaFlotante = $this->countNodosPaginaPosicionables % 3;
        $this->countNodosInparteSuperior = $nodosPorPosicion;
        $this->countNodosInParteMedia = $nodosPorPosicion + $moduloParteComaFlotante;
        $this->countNodosInParteInferior = $nodosPorPosicion;
        $this->punteroNodoPosicion = 0;
        $this->posicionPalabraEnDocumento = array("posicion_superior" => false, "posicion_media" => false, "posicion_inferior" => false);
        $this->palabraActual = $palabra;

        $nodeValues = $this->crawler->filterXpath('//body/*')->filter('*')->each(function (Crawler $node, $i) {
            if (($node->nodeName() != "script") && ($node->nodeName() != "iframe") && ($node->nodeName() != "noscript")) {
                if ($this->estaPalabraEnString(strtolower($this->extractTextoNodo($node), $this->palabraActual))) {
                    if (($this->punteroNodoPosicion >= 0) && ($this->punteroNodoPosicion < $this->countNodosInparteSuperior)) {//PosicionSuperior
                        $this->posicionPalabraEnDocumento["posicion_superior"] = true;
                    } else if (($this->punteroNodoPosicion >= $this->countNodosInparteSuperior) && ($this->punteroNodoPosicion < $this->countNodosInparteSuperior + $this->countNodosInParteMedia)) {//PosicionMedia
                        $this->posicionPalabraEnDocumento["posicion_media"] = true;
                    } else if (($this->punteroNodoPosicion >= $this->countNodosInparteSuperior + $this->countNodosInParteMedia) && ($this->punteroNodoPosicion < $this->countNodosPaginaPosicionables)) {//PosicionInferior
                        $this->posicionPalabraEnDocumento["posicion_inferior"] = true;
                    }
                }
                $this->punteroNodoPosicion++;
            }
        });
        return $this->posicionPalabraEnDocumento;
    }


    private function setCountNodosPaginaPosicionables() {
        $nodeValues = $this->crawler->filterXpath('//body/*')->filter('*')->each(function (Crawler $node, $i) {
            if (($node->nodeName() != "script") && ($node->nodeName() != "iframe") && ($node->nodeName() != "noscript")) {
                $this->countNodosPaginaPosicionables++;
            }
        });
    }
    
    function setStopWordsCastellano() {
        $this->stopWordsCastellano = array(
            "a",
            "y",
            "un",
            "una",
            "unas",
            "unos",
            "uno",
            "sobre",
            "todo",
            "también",
            "tras",
            "otro",
            "algún",
            "alguno",
            "alguna",
            "algunos",
            "algunas",
            "ser",
            "es",
            "soy",
            "eres",
            "somos",
            "sois",
            "estoy",
            "esta",
            "estamos",
            "estais",
            "estan",
            "como",
            "en",
            "para",
            "atras",
            "porque",
            "por qué",
            "estado",
            "estaba",
            "ante",
            "antes",
            "siendo",
            "ambos",
            "pero",
            "por",
            "poder",
            "puede",
            "puedo",
            "podemos",
            "podeis",
            "pueden",
            "fui",
            "fue",
            "fuimos",
            "fueron",
            "hacer",
            "hago",
            "hace",
            "hacemos",
            "haceis",
            "hacen",
            "cada",
            "fin",
            "incluso",
            "primero",
            "desde",
            "conseguir",
            "consigo",
            "consigue",
            "consigues",
            "conseguimos",
            "consiguen",
            "ir",
            "voy",
            "va",
            "vamos",
            "vais",
            "van",
            "vaya",
            "gueno",
            "ha",
            "tener",
            "tengo",
            "tiene",
            "tenemos",
            "teneis",
            "tienen",
            "el",
            "la",
            "lo",
            "las",
            "los",
            "su",
            "aqui",
            "mio",
            "tuyo",
            "ellos",
            "ellas",
            "nos",
            "nosotros",
            "vosotros",
            "vosotras",
            "si",
            "dentro",
            "solo",
            "solamente",
            "saber",
            "sabes",
            "sabe",
            "sabemos",
            "sabeis",
            "saben",
            "ultimo",
            "largo",
            "bastante",
            "haces",
            "muchos",
            "aquellos",
            "aquellas",
            "sus",
            "entonces",
            "tiempo",
            "verdad",
            "verdadero",
            "verdadera",
            "cierto",
            "ciertos",
            "cierta",
            "ciertas",
            "intentar",
            "intento",
            "intenta",
            "intentas",
            "intentamos",
            "intentais",
            "intentan",
            "dos",
            "bajo",
            "arriba",
            "encima",
            "valor",
            "muy",
            "era",
            "eras",
            "eramos",
            "eran",
            "modo",
            "bien",
            "cual",
            "cuando",
            "donde",
            "mientras",
            "quien",
            "con",
            "entre",
            "sin",
            "podria",
            "podrias",
            "podriamos",
            "podrian",
            "podriais",
            "yo",
            "aquel",
            "que",
            "del",
            "al",
            "de",
            "las",
            "les"
        );
    }

}
