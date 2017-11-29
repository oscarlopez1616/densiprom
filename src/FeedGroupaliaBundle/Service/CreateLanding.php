<?php

namespace FeedGroupaliaBundle\Service;

use Symfony\Component\DomCrawler\Crawler;
use FeedGroupaliaBundle\Entity\LineaFeed;

class CreateLanding {

    private $landing;
    private $target;
    private $preTemplateHTML;
    private $postTemplateHTML;

    function __construct($target = "groupalia") {
        ini_set('max_execution_time', 1800);
        if ($target == "facebook") {
            $marginLeft = "82";
        } else {
            $marginLeft = "248";
        }
        $this->target = $target;
        $buttonsNavigationCodeHtml = '<style TYPE="text/css">.lover_div{margin-bottom:50px;margin-top:50px;margin-left:' . $marginLeft . 'px;}.lover_button {  background: #3498db;  background-image: -webkit-linear-gradient(top, #3498db, #2980b9);  background-image: -moz-linear-gradient(top, #3498db, #2980b9);  background-image: -ms-linear-gradient(top, #3498db, #2980b9);  background-image: -o-linear-gradient(top, #3498db, #2980b9);  background-image: linear-gradient(to bottom, #3498db, #2980b9);  font-family: Arial;  color: #ffffff;  font-size: 20px;  padding: 10px 20px 10px 20px;  text-decoration: none;}.lover_button:hover {  background: #3cb0fd;  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);  text-decoration: none;}.lover_button_visited{  background: #3cb0fd;  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);  text-decoration: none;}</style>';
        $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '<div class="lover_div">';
        if ($this->target == "facebook") {
            $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '<a id="a_viajes_life_lovers" class="lover_button lover_button_visited" href="#" onclick="activaVertical(\'viajes_life_lovers\'); desactivaVertical(\'escapadas_life_lovers\'); desactivaVertical(\'cursos_life_lovers\'); desactivaVertical(\'productos_life_lovers\'); ">Viajes</a> ';
            $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '<a id="a_escapadas_life_lovers" class="lover_button" href="#" onclick="activaVertical(\'escapadas_life_lovers\'); desactivaVertical(\'viajes_life_lovers\'); desactivaVertical(\'cursos_life_lovers\'); desactivaVertical(\'productos_life_lovers\');">Escapadas</a>';
            $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '<a id="a_cursos_life_lovers" style="margin-left: 5px;" class="lover_button" href="#" onclick="activaVertical(\'cursos_life_lovers\'); desactivaVertical(\'viajes_life_lovers\'); desactivaVertical(\'escapadas_life_lovers\'); desactivaVertical(\'productos_life_lovers\');">Cursos</a>';
            $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '<a id="a_productos_life_lovers" style="margin-left: 5px;" class="lover_button" href="#" onclick="activaVertical(\'productos_life_lovers\'); desactivaVertical(\'escapadas_life_lovers\'); desactivaVertical(\'cursos_life_lovers\'); desactivaVertical(\'viajes_life_lovers\'); ">Productos</a>';
            $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '</div>';
            $this->preTemplateHTML = '<!--for life lovers facebook --><div class="content directory " style="width:800px!important;">
    ' . '<link rel="stylesheet" type="text/css" href="https://assetsjs.groupalia.com/assets-es/css/layout/layout.css?version=79a6aef25a3321da8dd07d4c4d01cd46" media="all"/>' . '<link rel="stylesheet" type="text/css" href="https://assetsjs.groupalia.com/assets-es/css/Template.css?version=6384af3b466da5ea764dff3a9695e86c" media="all"/>' . '<h1>For Life Lovers</h1><div id="summaryTop"><p>Para los amantes de la vida, para ti que lo eres y para los tuyos que también lo son.<br>Empieza a hacer lo que te gusta y ¡hazlo sin más!  Apuesta por las mejores experiencias en travelling y disfruta de tu tiempo libre, pero<br> sobre todo, hazlo con los tuyos. <a style="text-decoration:none !important;" href="http://es.blog.groupalia.com/2016/08/be-a-life-lover/" target="_blank">Descubre más sobre Life Lovers leyendo nuestro manifiesto</a></p></div>' . $buttonsNavigationCodeHtml . '<ul id="your-deals" class="imgList">';
            $this->preTemplateHTML = $this->preTemplateHTML . '<script   src="https://code.jquery.com/jquery-1.12.4.min.js"   integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="   crossorigin="anonymous"></script>';
            $this->preTemplateHTML = $this->preTemplateHTML . '<script>function desactivaVertical(idVertical) { jQuery("#"+idVertical).css("display", "none");jQuery("#a_"+idVertical).removeClass( "lover_button_visited" );}function activaVertical(idVertical) { jQuery("#"+idVertical).show();jQuery("#a_"+idVertical).addClass( "lover_button_visited" );}</script>';
            $this->preTemplateHTML = $this->preTemplateHTML . ' <script>jQuery( document ).ready(function() {desactivaVertical(\'escapadas_life_lovers\');desactivaVertical(\'cursos_life_lovers\');desactivaVertical(\'productos_life_lovers\');});</script>';
            $this->postTemplateHTML = '</ul></div>';
        } else {
            $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '<a id="a_viajes_life_lovers" class="lover_button lover_button_visited" href="#" onclick="activaVertical(\\\'viajes_life_lovers\\\'); desactivaVertical(\\\'escapadas_life_lovers\\\'); desactivaVertical(\\\'cursos_life_lovers\\\'); desactivaVertical(\\\'productos_life_lovers\\\'); ">Viajes</a> ';
            $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '<a id="a_escapadas_life_lovers" class="lover_button" href="#" onclick="activaVertical(\\\'escapadas_life_lovers\\\'); desactivaVertical(\\\'viajes_life_lovers\\\'); desactivaVertical(\\\'cursos_life_lovers\\\'); desactivaVertical(\\\'productos_life_lovers\\\');">Escapadas</a>';
            $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '<a id="a_cursos_life_lovers" style="margin-left: 5px;" class="lover_button" href="#" onclick="activaVertical(\\\'cursos_life_lovers\\\'); desactivaVertical(\\\'viajes_life_lovers\\\'); desactivaVertical(\\\'escapadas_life_lovers\\\'); desactivaVertical(\\\'productos_life_lovers\\\');">Cursos</a>';
            $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '<a id="a_productos_life_lovers" style="margin-left: 5px;" class="lover_button" href="#" onclick="activaVertical(\\\'productos_life_lovers\\\'); desactivaVertical(\\\'escapadas_life_lovers\\\'); desactivaVertical(\\\'cursos_life_lovers\\\'); desactivaVertical(\\\'viajes_life_lovers\\\'); ">Productos</a>';
            $buttonsNavigationCodeHtml = $buttonsNavigationCodeHtml . '</div>';
            $this->preTemplateHTML = "<!--for life lovers groupalia --><script type='text/javascript'>" . 'jQuery("title").html("For Life Lovers");' . 'jQuery("h1").text("For Life Lovers");';
            $this->preTemplateHTML = $this->preTemplateHTML .'function eliminarVaciarElementos(){jQuery("#your-deals > li").remove();jQuery("#summaryTop").remove();jQuery("#summaryBottom").remove();}';//borrar si sale oferta cinesa
            $this->preTemplateHTML = $this->preTemplateHTML . 'function desactivaVertical(idVertical) { jQuery("#"+idVertical).css("display", "none");jQuery("#a_"+idVertical).removeClass( "lover_button_visited" );}function activaVertical(idVertical) { jQuery("#"+idVertical).show();jQuery("#a_"+idVertical).addClass( "lover_button_visited" );}';
            $this->preTemplateHTML = $this->preTemplateHTML . 'jQuery( document ).ready(function() {desactivaVertical(\'escapadas_life_lovers\');desactivaVertical(\'cursos_life_lovers\');desactivaVertical(\'productos_life_lovers\');eliminarVaciarElementos();});';
            $this->preTemplateHTML = $this->preTemplateHTML . 'window.location = "#for-life-lovers";';
            $this->preTemplateHTML = $this->preTemplateHTML . 'jQuery(\'<div id="summaryTop"><p>Para los amantes de la vida, para ti que lo eres y para los tuyos que también lo son.<br>Empieza a hacer lo que te gusta y ¡hazlo sin más!  Apuesta por las mejores experiencias en travelling y disfruta de tu tiempo libre, pero sobre todo, hazlo con los tuyos. <a style="text-decoration:none !important;" href="http://es.blog.groupalia.com/2016/08/be-a-life-lover/" target="_blank">Descubre más sobre Life Lovers leyendo nuestro manifiesto</a></p></div>\').insertBefore("#your-deals");';
            $this->preTemplateHTML = $this->preTemplateHTML . 'jQuery(\'' . $buttonsNavigationCodeHtml . '\').insertBefore("#your-deals");';
            $this->postTemplateHTML = '</script>';
        }
    }

    function getLanding() {
        return $this->landing;
    }

    function setLandingBySkuArray($skuArray, $DoctrineEntityManager) {
        $this->landing = $this->preTemplateHTML;
        $j = 0;
        $verticalName = "";
        foreach ($skuArray as $key => $valueArray) {
            $LineaFeedArray = $this->getLineaFeedArrayBySkuArray($valueArray, $DoctrineEntityManager);
            if (count($LineaFeedArray) == 0)
                throw new \Exception('NoLineaFeedInCaspas');
            $i = 2;
            switch ($j) {
                case 0:
                    $verticalName = "viajes_life_lovers";
                    break;
                case 1:
                    $verticalName = "escapadas_life_lovers";
                    break;
                case 2:
                    $verticalName = "cursos_life_lovers";
                    break;
                case 3:
                    $verticalName = "productos_life_lovers";
                    break;
            }

            if ($this->target == "facebook") {
                $this->landing = $this->landing . '<div id="' . $verticalName . '">';
            } else {
                $this->landing = $this->landing . 'jQuery("#your-deals").append(\'<div id="' . $verticalName . '"></div>\');';
            }
            foreach ($LineaFeedArray as $LineaFeed) {
                $this->landing = $this->landing . $this->getDeal($LineaFeed, $i, $verticalName);
                $i++;
            }
            $j++;
            if ($this->target == "facebook") {
                $this->landing = $this->landing . "</div>";
            }
        }

        $this->landing = $this->landing . $this->postTemplateHTML;
    }

    private function getDeal($LineaFeed, $indexDeal, $verticalName) {
        $image = $LineaFeed->getImage();
        $shortTitle = $this->cortaStringLargo($LineaFeed->getShortTitle());
        $address = $this->cortaStringLargo($LineaFeed->getAddressInGeoLocations());
        
        $discount = $LineaFeed->getDiscountInPrince();
        if($discount != "")$discount = $discount."%dto";
        
        $price = $LineaFeed->getPriceInPrince();
        if($price != "")$price = $price."€";
        
        $specialPrice = $LineaFeed->getSpecialPriceInPrince();
        if($specialPrice != "")$specialPrice = $specialPrice."€";
        
        $sku = $LineaFeed->getSku();

        if ($this->target == "facebook") {
            $utmGoogle = "?utm_source=facebook&utm_medium=pestaña_for_life_lovers&utm_content=deal_for_life_lovers&utm_campaign=for_life_lovers";
            $canonicalUrl = $LineaFeed->getCanonicalUrl() . $utmGoogle;
            $anchorBlank = 'target="_blank"';
            $protocol = "https";
            $dealTemp = "";
            $insertDom = '';
        } else {
            $canonicalUrl = $LineaFeed->getCanonicalUrl();
            $anchorBlank = "";
            $protocol = "http";
            $dealTemp = 'var deal =\'';
            $insertDom = '\';jQuery("#' . $verticalName . '").append(deal);';
        }
        $dealTemp = $dealTemp . '<li class="flash" itemscope itemtype="' . $protocol . '://schema.org/Product" alt="393151"><a name="' . $indexDeal . '" href="' . $canonicalUrl . '" ' . $anchorBlank . '><span style="display: none;">R:</span><img itemprop="image" class="image" data-original="' . $image . '" src="' . $image . '" alt="SinNombre_1" height="210" width="274" style="display: block;"></a><div class="dealTitle"><span class="dtotitulo-mb txt-mb" style="display:none;">-62%</span>        <a href="' . $canonicalUrl . '" title="' . $shortTitle . '" itemprop="name" class="title_multi myEllipsis" ' . $anchorBlank . '>' . $shortTitle . '        </a></div><div class="survey-rating empty "><span class="rating">Compra y deja tu valoración</span></div>    <p class="price_grp" itemprop="offers" itemscope="" itemtype="' . $protocol . '://schema.org/AggregateOffer"><span class="original" itemprop="highPrice">' . $price . '</span><span class="dto dto-mb">' . $discount . '</span><span class="price txt-mb" itemprop="lowPrice">' . $specialPrice . '</span><a href="' . $canonicalUrl . '" class="btn btn-mb" itemprop="url" ' . $anchorBlank . '>Ver</a></p></li>' . $insertDom;
        return $dealTemp;
    }

    /*
     * $SkuArray array[int] de skus array(0=>'CASPA0000321192',1=>'CASPA0000321127',2=>'CASPA0000321274',3=>'CASPA0000321496');
     */

    private function getLineaFeedArrayBySkuArray($skuArray, $DoctrineEntityManager) {
        $LineaFeedArray = array();
        $LineaFeedArray = $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed')->findBy(array('sku' => $skuArray));
        $lineaFeedArrayTemp = array();
        foreach ($skuArray as $keySku => $sku) {
            foreach ($LineaFeedArray as $keyLineaFeed => $LineaFeed) {
                if ($sku === $LineaFeed->getSku())
                    array_push($lineaFeedArrayTemp, $LineaFeed);
            }
        }
        return $lineaFeedArrayTemp;
    }

    private function cortaStringLargo($string) {
        $string = substr($string, 0, 81);
        return $string;
    }

}
