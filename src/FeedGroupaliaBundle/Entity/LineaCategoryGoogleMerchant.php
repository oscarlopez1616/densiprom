<?php

namespace FeedGroupaliaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineaCategoryGoogleMerchant
 *
 * @ORM\Table(name="linea_category_google_merchant",uniqueConstraints={@ORM\UniqueConstraint(name="id_google_unique_index", columns={"id_google"})})
 * @ORM\Entity(repositoryClass="FeedGroupaliaBundle\Repository\LineaCategoryGoogleMerchantRepository")
 */
class LineaCategoryGoogleMerchant {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="integer",nullable=false) */
    private $idGoogle;

    /** @ORM\Column(length=500,nullable=false) */
    private $category;

    /** @ORM\Column(length=500,nullable=true) */
    private $category2;

    /** @ORM\Column(length=500,nullable=true) */
    private $category3;

    /** @ORM\Column(length=500,nullable=true) */
    private $category4;

    /** @ORM\Column(length=500,nullable=true) */
    private $category5;

    /**
     * Get id
     *    private $category4;
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    function getIdGoogle() {
        return $this->id_google;
    }

    function setIdGoogle($id_google) {
        $this->id_google = $id_google;
    }

    function getCategory() {
        return $this->category;
    }

    function getCategory2() {
        return $this->category2;
    }

    function getCategory3() {
        return $this->category3;
    }

    function getCategory4() {
        return $this->category4;
    }

    function getCategory5() {
        return $this->category5;
    }

    function getCategoryCompletaParaFeed() {
        $categoria = $this->getCategory();
        if (isset($this->Category2) && !$this->Category2 == "") {
            $categoria = $categoria . " > " . $this->getCategory2();
            if (isset($this->Category3) && !$this->Category3 == "") {
                $categoria = $categoria . " > " . $this->getCategory3();
                if (isset($this->Category4) && !$this->Category4 == "") {
                    $categoria = $categoria . " > " . $this->getCategory4();
                }
            }
        }
        return $categoria;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    function setCategory2($category2) {
        $this->category2 = $category2;
    }

    function setCategory3($category3) {
        $this->category3 = $category3;
    }

    function setCategory4($category4) {
        $this->category4 = $category4;
    }

    function setCategory5($category5) {
        $this->category5 = $category5;
    }

}
