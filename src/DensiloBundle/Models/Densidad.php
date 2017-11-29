<?php

namespace DensiloBundle\Models;

class Densidad {

    private $porcentajeSobreTotalDocumento;
    private $numApariciones;
    private $stringPalabra;
    private $documentoArreglo;
    private $documentoPalabras;
    private $documentoPalabrasUnique;

    function __construct($stringPalabra, array $documentoArreglo, array $documentoPalabras, array $documentoPalabrasUnique) {
        $this->porcentajeSobreTotalDocumento = 0;
        $this->numApariciones = 0;
        $this->stringPalabra = $stringPalabra;
        $this->documentoArreglo = $documentoArreglo;
        $this->documentoPalabras = $documentoPalabras;
        $this->documentoPalabrasUnique = $documentoPalabrasUnique;
        $this->calculaDensidad();
    }

    function calculaDensidad() {
        foreach ($this->documentoPalabras as $key => $value) {
            if($value === $this->stringPalabra) $this->addNumApariciones();
        }
        $totalPalabrasDocumento = count($this->documentoPalabras);
        $this->porcentajeSobreTotalDocumento = ($this->numApariciones/$totalPalabrasDocumento) *100;
    }

    private function addNumApariciones() {
        $this->numApariciones = $this->numApariciones + 1;
    }

    function getPorcentajeSobreTotalDocumento() {
        return $this->porcentajeSobreTotalDocumento;
    }

    function getPorcentajeSobreTotalDocumentoRounded() {
        return round($this->porcentajeSobreTotalDocumento,2);
    }
   
    
    function getNumApariciones() {
        return $this->numApariciones;
    }

}
