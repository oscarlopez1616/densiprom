<?php

namespace DensiloBundle\Models;

class Prominencia {

    private $prominenciaValores;
    private $numApariciones;
    private $numAparicionesSitiosProminentes;
    private $posicionPalabraEnDocumento;
    private $stringPalabra;
    private $documentoArregloProminencia;
    private $documentoPalabras;
    private $documentoPalabrasUnique;
    private $valorProminencia;

    function __construct($stringPalabra, array $documentoArregloProminencia, array $documentoPalabras, array $documentoPalabrasUnique, $numApariciones, $posicionPalabraEnDocumento) {
        $this->stringPalabra = $stringPalabra;
        $this->numApariciones = $numApariciones;
        $this->posicionPalabraEnDocumento = $posicionPalabraEnDocumento;
        $this->documentoArregloProminencia = $documentoArregloProminencia;
        $this->documentoPalabras = $documentoPalabras;
        $this->documentoPalabrasUnique = $documentoPalabrasUnique;
        $this->prominenciaValores["host"]["numApariciones"] = 0;
        $this->prominenciaValores["url"]["numApariciones"] = 0;
        $this->prominenciaValores["metaKeyword"]["numApariciones"] = 0;
        $this->prominenciaValores["metaDescription"]["numApariciones"] = 0;
        $this->prominenciaValores["encabezadoH1"]["numApariciones"] = 0;
        $this->prominenciaValores["encabezadoH2"]["numApariciones"] = 0;
        $this->prominenciaValores["encabezadoH3"]["numApariciones"] = 0;
        $this->prominenciaValores["encabezadoH4"]["numApariciones"] = 0;
        $this->prominenciaValores["encabezadoH5"]["numApariciones"] = 0;
        $this->prominenciaValores["encabezadoH6"]["numApariciones"] = 0;
        $this->prominenciaValores["anchor"]["numApariciones"] = 0;
        $this->prominenciaValores["bold"]["numApariciones"] = 0;
        $this->prominenciaValores["italic"]["numApariciones"] = 0;
        $this->prominenciaValores["imagenAlt"]["numApariciones"] = 0;
        $this->prominenciaValores["li"]["numApariciones"] = 0;
        $this->prominenciaValores["conexionTallo"]["numApariciones"] = 0;
        $this->valorProminencia = 0;
        $this->numAparicionesSitiosProminentes = 0;
        $this->setPesosProminencia();
        $this->calculaProminencia();
    }

    /**
     * La prominencia va de 0 a 100 donde 0 es nada importante y 100 es muy importante
     * los encabezados solo suman una vez y suma la aparicion mas importante es decir si
     * aparece h1 y h2 y h3 contara h1
     * cada repeticion de la palabra decrece 1.67 la prominencia
     */
    function calculaProminencia() {
        foreach ($this->documentoArregloProminencia as $key => $value) {
            $nodeProminenciaArr = explode(" ", $value);
            foreach ($nodeProminenciaArr as $key2 => $value2) {
                if ($value2 == $this->stringPalabra) {
                    $this->addProminencia($key);
                }
            }
        }
        $flag_encabezado_contado = false;
        $acumuladorEncabezadoKeyContado = NULL;
        foreach ($this->prominenciaValores as $key => $value) {
            if ($value["numApariciones"] > 0) {
                if (($key == "encabezadoH1" || $key == "encabezadoH2" || $key == "encabezadoH3" || $key == "encabezadoH4" || $key == "encabezadoH5" || $key == "encabezadoH6") && !$flag_encabezado_contado) {
                    if ($this->encabezadoEsMasPequeno($key, $acumuladorEncabezadoKeyContado)) { //si es mas pequeño sustituye el peso del mas pequeño ejemplo sustituir h2 por h1
                        $this->valorProminencia = $this->valorProminencia + $value["peso"];
                        $this->valorProminencia = $this->valorProminencia - $this->proprominenciaValores[$acumuladorEncabezadoKeyContado]["peso"]; //resta el anterior encabezado inferior
                        $acumuladorEncabezadoKeyContado = $key;
                        if ($key == "encabezadoH1")
                            $flag_encabezado_contado = true; // que ya no cuente mas ha llegado al mas pequeño
                    }
                } else {
                    $this->valorProminencia = $this->valorProminencia + $value["peso"];
                    $this->numAparicionesSitiosProminentes++;
                }
            }
        }

        $this->atenuadorProminencia();
        $this->atenuadorPosicionProminencia($this->posicionPalabraEnDocumento);
        $this->atenuadorEntreDensidadProminencia();
    }

    /**
     * Compara $encabezaPos0 con $encabezaPos1 y devuelve true si 1 es mas pequeño que 2
     * @param string $encabezaPos1
     * @param string $encabezaPos2
     * @return boolean
     */
    private function encabezadoEsMasPequeno($encabezaPos0, $encabezaPos1) {
        if (!isset($encabezaPos1)) {
            $this->numAparicionesSitiosProminentes++; // solo cuenta el primer encabezado
            return true;
        }
        $enc1 = intval(preg_replace('/[^0-9]+/', '', $encabezaPos0), 10);
        $enc2 = intval(preg_replace('/[^0-9]+/', '', $encabezaPos1), 10);
        if ($enc1 < $enc2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param string $posicionPalabraEnDocumento
     */
    private function atenuadorPosicionProminencia($posicionPalabraEnDocumento) {
        switch ($posicionPalabraEnDocumento) {
            case "posicion_superior_media_inferior":
                $atenuador = 1;
                break;
            case "posicion_superior_media":
                $atenuador = 0.82;
                break;
            case "posicion_superior_inferior":
                $atenuador = 0.54;
                break;
            case "posicion_media_inferior":
                $atenuador = 0.82;
                break;
            case "posicion_superior":
                $atenuador = 0.71;
                break;
            case "posicion_media":
                $atenuador = 0.71;
                break;
            case "posicion_inferior":
                $atenuador = 0.18;
                break;
        }
        $this->valorProminencia = $this->valorProminencia *$atenuador;
    }

    /**
     * atenua la prominencia en funcion del numero de apariciones en sitios promientes
     */
    private function atenuadorProminencia() {
        if ($this->numAparicionesSitiosProminentes == 0) {
            $this->valorProminencia = $this->valorProminencia / 1;
        } else {
            $this->valorProminencia = $this->valorProminencia / $this->numAparicionesSitiosProminentes;
        }
    }

    private function atenuadorEntreDensidadProminencia() {
        $atenuador = 1;

        $this->valorProminencia = $this->valorProminencia - ($atenuador * $this->numApariciones);
    }

    function getValorProminencia() {
        return $this->valorProminencia;
    }

    function getValorProminenciaRounded() {
        return round($this->valorProminencia, 2);
    }

    /**
     *
     * @return string
     */
    function getPosicionesPromientes() {
        $tempString = "";
        foreach ($this->prominenciaValores as $key => $value) {
            if ($this->prominenciaValores["host"]["numApariciones"] >= 1)
                $tempString = $tempString . " host";
            if ($this->prominenciaValores["metaTitulo"]["numApariciones"] >= 1)
                $tempString = $tempString . " metaTitulo";
            if ($this->prominenciaValores["encabezadoH1"]["numApariciones"] >= 1)
                $tempString = $tempString . " encabezadoH1";
            if ($this->prominenciaValores["url"]["numApariciones"] >= 1)
                $tempString = $tempString . " url";
            if ($this->prominenciaValores["metaDescription"]["numApariciones"] >= 1)
                $tempString = $tempString . " metaDescription";
            if ($this->prominenciaValores["conextionTallo"]["numApariciones"] >= 1)
                $tempString = $tempString . " conextionTallo";
            if ($this->prominenciaValores["encabezadoH2"]["numApariciones"] >= 1)
                $tempString = $tempString . " encabezadoH2";
            if ($this->prominenciaValores["encabezadoH3"]["numApariciones"] >= 1)
                $tempString = $tempString . " encabezadoH3";
            if ($this->prominenciaValores["bold"]["numApariciones"] >= 1)
                $tempString = $tempString . " bold";
            if ($this->prominenciaValores["italic"]["numApariciones"] >= 1)
                $tempString = $tempString . " italic";
            if ($this->prominenciaValores["anchor"]["numApariciones"] >= 1)
                $tempString = $tempString . " anchor";
            if ($this->prominenciaValores["encabezadoH4"]["numApariciones"] >= 1)
                $tempString = $tempString . " encabezadoH4";
            if ($this->prominenciaValores["li"]["numApariciones"] >= 1)
                $tempString = $tempString . " li";
            if ($this->prominenciaValores["encabezadoH5"]["numApariciones"] >= 1)
                $tempString = $tempString . " encabezadoH5";
            if ($this->prominenciaValores["encabezadoH6"]["numApariciones"] >= 1)
                $tempString = $tempString . " encabezadoH6";
            if ($this->prominenciaValores["imagenAlt"]["numApariciones"] >= 1)
                $tempString = $tempString . " imagenAlt";
            if ($this->prominenciaValores["metaKeyword"]["numApariciones"] >= 1)
                $tempString = $tempString . " metaKeyword";
        }
        $arrayTemp=explode(" ",$tempString);
        $resultado = array_unique($arrayTemp);
        $resultado = implode(" ",$resultado);

        return $resultado;
    }

    /**
     * 17 variables a tener en cuenta vamos de n asta n-1
     * peso 1 el menos importante y 16 el mas importante de los pesos
     */
    private function setPesosProminencia() {
        $this->prominenciaValores["host"]["peso"] = 100;
        $this->prominenciaValores["metaTitulo"]["peso"] = 95;
        $this->prominenciaValores["encabezadoH1"]["peso"] = 90;
        $this->prominenciaValores["url"]["peso"] = 85;
        $this->prominenciaValores["metaDescription"]["peso"] = 80;
        $this->prominenciaValores["conextionTallo"]["peso"] = 70;
        $this->prominenciaValores["encabezadoH2"]["peso"] = 85;
        $this->prominenciaValores["encabezadoH3"]["peso"] = 80;
        $this->prominenciaValores["bold"]["peso"] = 75;
        $this->prominenciaValores["italic"]["peso"] = 75;
        $this->prominenciaValores["anchor"]["peso"] = 70;
        $this->prominenciaValores["encabezadoH4"]["peso"] = 75;
        $this->prominenciaValores["li"]["peso"] = 70;
        $this->prominenciaValores["encabezadoH5"]["peso"] = 70;
        $this->prominenciaValores["encabezadoH6"]["peso"] = 65;
        $this->prominenciaValores["imagenAlt"]["peso"] = 65;
        $this->prominenciaValores["metaKeyword"]["peso"] = 60;
    }

    function addProminencia($tipoNodo) {
        switch ($tipoNodo) {
            case "conexion_tallo"://todavia no esta calculada en $documentoArregloProminencia
                $this->prominenciaValores["conexionTallo"]["numApariciones"] ++;
                break;
            case "host_uri":
                $this->prominenciaValores["host"]["numApariciones"] ++;
                break;
            case "uri":
                $this->prominenciaValores["url"]["numApariciones"] ++;
                break;
            case "title":
                $this->prominenciaValores["metaTitulo"]["numApariciones"] ++;
                break;
            case "meta_description":
                $this->prominenciaValores["metaDescription"]["numApariciones"] ++;
                break;
            case "meta_keywords":
                $this->prominenciaValores["metaKeyword"]["numApariciones"] ++;
                break;
            case "h1":
                $this->prominenciaValores["encabezadoH1"]["numApariciones"] ++;
                break;
            case "h2":
                $this->prominenciaValores["encabezadoH2"]["numApariciones"] ++;
                break;
            case "h3":
                $this->prominenciaValores["encabezadoH3"]["numApariciones"] ++;
                break;
            case "h4":
                $this->prominenciaValores["encabezadoH4"]["numApariciones"] ++;
                break;
            case "h5":
                $this->prominenciaValores["encabezadoH5"]["numApariciones"] ++;
                break;
            case "h6":
                $this->prominenciaValores["encabezadoH6"]["numApariciones"] ++;
                break;
            case "b":
                $this->prominenciaValores["bold"]["numApariciones"] ++;
                break;
            case "strong":
                $this->prominenciaValores["bold"]["numApariciones"] ++;
                break;
            case "italic":
                $this->prominenciaValores["italic"]["numApariciones"] ++;
                break;
            case "i":
                $this->prominenciaValores["italic"]["numApariciones"] ++;
                break;
            case "a":
                $this->prominenciaValores["anchor"]["numApariciones"] ++;
                break;
            case "ialt":
                $this->prominenciaValores["imagenAlt"]["numApariciones"] ++;
                break;
            case "li":
                $this->prominenciaValores["li"]["numApariciones"] ++;
                break;
        }
    }

}
