<?php

namespace FeedGroupaliaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineaLog
 *
 * @ORM\Table(name="linea_log" ,uniqueConstraints={@ORM\UniqueConstraint(name="type_servicio_unique_index", columns={"type_servicio"})})
 * @ORM\Entity(repositoryClass="FeedGroupaliaBundle\Repository\LineaLogRepository")
 */
class LineaLog {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /** @ORM\Column(type="datetime",nullable=false) */
    private $datetimeUltimoServicioEjecutado;

    /** @ORM\Column(length=255,nullable=false) */
    private $typeServicio;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    function getDatetimeUltimoServicioEjecutado() {
        return $this->datetimeUltimoServicioEjecutado;
    }

    function getTypeServicio() {
        return $this->typeServicio;
    }

    function setDatetimeUltimoServicioEjecutado($datetimeUltimoServicioEjecutado) {
        $this->datetimeUltimoServicioEjecutado = $datetimeUltimoServicioEjecutado;
    }

    function setTypeServicioLineaFeed($family) {
        if($family=="all") $family="";//hacemos esto porque las LineaFeed para todos las familias se llaman LineaFeed no LineaFeedAll
        $this->typeServicio = "LineaFeed".$family;
    }
    
    function setTypeServicioLineaBI() {
        $this->typeServicio = "LineaBI";
    }
    
    function setTypeServicioLineaSalesForce() {
        $this->typeServicio = "LineaSalesForce";
    }
    
    function setTypeServicioLineaGoogleAnalytics() {
        $this->typeServicio = "LineaGoogleAnalytics";
    }

}
