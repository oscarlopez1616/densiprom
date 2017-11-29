<?php

namespace FeedGroupaliaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FeedGroupaliaBundle\Entity\LineaCategoryGoogleMerchant;

/**
 * MapeoGoogleCategoryWithGroupalia
 *
 * @ORM\Table(name="mapeo_google_category_with_groupalia",uniqueConstraints={@ORM\UniqueConstraint(name="linea_category_google_merchant_id_unique_index", columns={"linea_category_google_merchant_id"})})
 * @ORM\Entity(repositoryClass="FeedGroupaliaBundle\Repository\MapeoGoogleCategoryWithGroupaliaRepository")
 */
class MapeoGoogleCategoryWithGroupalia {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="integer",nullable=true) */
    private $idGroupalia;

    /**
     * @ORM\OneToOne(targetEntity="LineaCategoryGoogleMerchant")
     * @ORM\JoinColumn(name="linea_category_google_merchant_id", referencedColumnName="id")
     */
    private $LineaCategoryGoogleMerchant;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    function getIdGroupalia() {
        return $this->idGroupalia;
    }
    
    /**
     * 
     * @return LineaCategoryGoogleMerchant
     */
    function getLineaCategoryGoogleMerchant() {
        return $this->LineaCategoryGoogleMerchant;
    }
    
    function setIdGroupalia($idGroupalia) {
        $this->idGroupalia = $idGroupalia;
    }

    /**
     * 
     * @param LineaCategoryGoogleMerchant
     */
    function setLineaCategoryGoogleMerchant($LineaCategoryGoogleMerchant) {
        $this->LineaCategoryGoogleMerchant = $LineaCategoryGoogleMerchant;
    }

}
