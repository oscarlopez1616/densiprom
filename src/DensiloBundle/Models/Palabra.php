<?php

namespace DensiloBundle\Models;

class Palabra {

    private $stringPalabra;

    /**
     *
     * @var Densidad 
     */
    private $Densidad;

    /**
     *
     * @var Prominencia 
     */
    var $Prominencia;

    function __construct($stringPalabra, Densidad $Densidad, Prominencia $Prominencia) {
        $this->stringPalabra = $stringPalabra;
        $this->Densidad = $Densidad;
        $this->Prominencia = $Prominencia;
    }

    function getStringPalabra() {
        return $this->stringPalabra;
    }

    function getDensidad() {
        return $this->Densidad;
    }

    function getProminencia() {
        return $this->Prominencia;
    }

    function getScore() {
        return round($this->Densidad->getPorcentajeSobreTotalDocumentoRounded() * $this->Prominencia->getValorProminencia(), 2);
    }

}
