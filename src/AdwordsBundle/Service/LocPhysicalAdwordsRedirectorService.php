<?php
namespace AdwordsBundle\Service;

class LocPhysicalAdwordsRedirectorService {

    private $_urlRedirectWhithoutSlugCity;
    private $_locPhysicalAdwords;
    function __construct($urlRedirectWhithoutSlugCity,$locPhysicalAdwords) {
        $this->_urlRedirectWhithoutSlugCity = urldecode($urlRedirectWhithoutSlugCity);
        $this->_locPhysicalAdwords = $locPhysicalAdwords;
    }
    
    public function getUrlRedirectWithSlugCityLb(){
        return "http://".$this->_urlRedirectWhithoutSlugCity.$this->getSlugCityLbBylocPhysicalAdwords();
    }
    
    public function setlocPhysicalAdwords($locPhysicalAdwords){
        $this->_locPhysicalAdwords = $locPhysicalAdwords;
    }
    
    private function getSlugCityLbBylocPhysicalAdwords(){
        $slugCityLb = "";
        switch ($this->_locPhysicalAdwords) {
            case 20299:
                $slugCityLb = "vitoria";
                break;
            case 9047057:
                $slugCityLb = "albacete";
                break;
            case 20267:
                $slugCityLb = "alicante";
                break;
            case 20268:
                $slugCityLb = "almeria";
                break;
            case 9047040:
                $slugCityLb = "oviedo";
                break;
            case 9047044:
                $slugCityLb = "avila";
                break;
            case 9047037:
                $slugCityLb = "badajoz";
            case 20270:
                $slugCityLb = "barcelona";
            case 9047048:
                $slugCityLb = "burgos";
            case 9047048:
                $slugCityLb = "caceres";
            case 20273:
                $slugCityLb = "cadiz";
            case 9047050:
                $slugCityLb = "santander";
            case 9047055:
                $slugCityLb = "castellon";
            case 9047059:
                $slugCityLb = "ciudad-real";
            case 9047060:
                $slugCityLb = "cordoba";
            case 20272:
                $slugCityLb = "a-coruna";
            case 9047058:
                $slugCityLb = "cuenca";
            case 9047033:
                $slugCityLb = "girona";
            case 9047061:
                $slugCityLb = "granada";
            case 9047046:
                $slugCityLb = "guadalajara";
            case 20293:
                $slugCityLb = "san-sebastian";
            case 9047035:
                $slugCityLb = "huelva";
            case 9047052:
                $slugCityLb = "huesca";
            case 20287:
                $slugCityLb = "mallorca";
            case 9047062:
                $slugCityLb = "jaen";
            case 9047041:
                $slugCityLb = "leon";
            case 9047032:
                $slugCityLb = "lleida";
            case 9047039:
                $slugCityLb = "lugo";
            case 9047045:
                $slugCityLb = "madrid";
            case 9047063:
                $slugCityLb = "malaga";
            case 9047056:
                $slugCityLb = "murcia";
            case 9047051:
                $slugCityLb = "pamplona";
            case 9047043:
                $slugCityLb = "orense";
            case 9047049:
                $slugCityLb = "palencia";
            case 9047034:
                $slugCityLb = "las-palmas-de-gc";
            case 20288:
                $slugCityLb = "pontevedra";
            case 9047053:
                $slugCityLb = "logrono";
            case 20291:
                $slugCityLb = "salamanca";
            case 20292:
                $slugCityLb = "segovia";
            case 9047036:
                $slugCityLb = "sevilla";
            case 9047047:
                $slugCityLb = "soria";
            case 20294:
                $slugCityLb = "tarragona";
            case 20295:
                $slugCityLb = "santa-cruz-de-tenerife";
            case 9047054:
                $slugCityLb = "teruel";
            case 20296:
                $slugCityLb = "toledo";
            case 20297:
                $slugCityLb = "valencia";
            case 20298:
                $slugCityLb = "valladolid";
            case 20271:
                $slugCityLb = "bilbao";
            case 9047042:
                $slugCityLb = "zamora";
            case 20300:
                $slugCityLb = "zaragoza";
            case 1005508:
                $slugCityLb = "gijon";
            case 1005483:
                $slugCityLb = "santiago-de-compostela";
            case 1005518:
                $slugCityLb = "vigo";
        }
        return $slugCityLb;
    }
}
