<?php

namespace FeedGroupaliaBundle\Service;

use Symfony\Component\DomCrawler\Crawler;
use FeedGroupaliaBundle\Entity\LineaVentaSourceBi;

class ReadVentasCsvBi {

    private $csvName;
    private $hostTempPath;

    function __construct() {
        ini_set('max_execution_time', 1800);
        ini_set('memory_limit', '128M');
        $this->csvName = "ventas-por-sku.csv";
        $this->hostTempPath = "http://localhost/densiprom/web/";
        $urlCsv = "http://groupalia.e-fbk.com/" . $this->csvName;
        $csv = file_get_contents($urlCsv);
        file_put_contents(urldecode($this->csvName), $csv);
        unset($csv);
    }

    /**
     * los campos del csv tienen que estar de la siguiente manera
     * 
      [0] => Date
      [1] => Gross Sales (EUR)
      [2] => Net Sales (EUR)
      [3] => Sku
      [4] => ID Order
      [5] => Voucher Code
      [6] => Price
      [7] => Discount Percent
      [8] => Original Price
     * @param type $DoctrineEntityManager
     */
    function SetLineaBiInCsvInBiToBBDD($DoctrineEntityManager) {
        $datoCsv = array();
        if (($gestor = fopen($this->hostTempPath . $this->csvName, "r")) !== FALSE) {
            $nombres_campos = fgetcsv($gestor);
            $num_campos = count($nombres_campos);
            $i = 0;
            $j = 0;
            while (($datos = fgetcsv($gestor, 1000, "\t")) !== FALSE) {
                $datoCsv["date"] = $datos[0];
                $datoCsv["grossSales"] = $datos[1];
                $datoCsv["netSales"] = $datos[2];
                $datoCsv["sku"] = $datos[3];
                $datoCsv["idOrder"] = $datos[4];
                $datoCsv["voucherCode"] = $datos[5];
                $datoCsv["price"] = $datos[6];
                $datoCsv["discountPercent"] = $datos[7];
                $datoCsv["originalPrice"] = $datos[8];
                $this->newArrayFeedToBBDD($datoCsv, $DoctrineEntityManager);
                echo "flush";
                if ($j % 50 == 0) {
                    $DoctrineEntityManager->flush();
                    $DoctrineEntityManager->clear();
                }
                $j++;
            }
            fclose($gestor);
            unlink(urldecode($this->csvName));
        }
    }

    private function newArrayFeedToBBDD($datoCsv, $DoctrineEntityManager) {
        $LineaVentaSourceBi = new LineaVentaSourceBi();
        $LineaVentaSourceBi->setDate($datoCsv["date"]);
        $LineaVentaSourceBi->setDiscountPercent($datoCsv["discountPercent"]);
        $LineaVentaSourceBi->setGrossSales($datoCsv["grossSales"]);
        $LineaVentaSourceBi->setNetSales($datoCsv["netSales"]);
        $LineaVentaSourceBi->setIdOrder($datoCsv["idOrder"]);
        $LineaVentaSourceBi->setNetSales($datoCsv["netSales"]);
        $LineaVentaSourceBi->setOriginalPrice($datoCsv["originalPrice"]);
        $LineaVentaSourceBi->setPrice($datoCsv["price"]);
        $LineaVentaSourceBi->setSku($datoCsv["sku"]);
        $LineaVentaSourceBi->setVoucherCode($datoCsv["voucherCode"]);
        
        /*Guardar ventas de las lineasde producto
        $DoctrineEntityManager->getRepository('FeedGroupaliaBundle:LineaFeed');
        $DoctrineEntityManager->persist($LineaBi);
         * */
    }

}
