<?php

namespace FeedGroupaliaBundle\Service;

use Symfony\Component\DomCrawler\Crawler;
use FeedGroupaliaBundle\Entity\LineaFeed;

class CreateMailSelligent {

    private $mail;
    private $preTemplateHTML;
    private $postTemplateHTML;
    private $separadorHTML;
    private $preTwoColumsHTML;
    private $postTwoColumsHTML;
    private $selligentSensor;

    function __construct() {
        $this->preTemplateHTML = '<center style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background: #eee; table-layout: fixed; width: 100%"><div style="margin: 0 auto; max-width: 600px">	<!-- Structural Outer Container --><!--[if (gte mso 9)|(IE)]>            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">            <tr>            <td>            <![endif]-->	<table align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5; margin: 0 auto; max-width: 600px; width: 100%">		<tbody>			<tr>				<td style="padding: 0"><!-- Preheader -->				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">					<tbody>						<tr>							<td style="color: #707070; padding: 10px; text-align: center" align="center">Planes de Ocio, Belleza, Escapadas, Viajes y Productos<br />							<a style="color: #707070" target="_blank"  href="~PROBE(0)~">Ver Versi&oacute;n online</a><span style="padding: 0 10px">&nbsp;|&nbsp;</span><a style="color: #007ea7" target="_blank" href="~PROBE(203)~">Darme de baja</a></td>						</tr>					</tbody>				</table>				<!-- Header -->				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">					<tbody>						<tr>							<td style="background: #007ea7; height: 50px; padding: 0" bgcolor="#007ea7"><a style="display: inline-block" target="_blank"  href="~PROBE(201)~"><img width="180" alt="Groupalia" style="border: 0" src="http://multimedia.groupalia.com/static/img/emails/newsletter/transaccionales_2014/newdesign/logo-nl-gp.png" /> </a></td>						</tr>					</tbody>				</table>				<div id="MASECTION" macontenteditable="FALSE" maconstraint="" maparameter="BLOQUE_HTML" matype="" mahidediv="true">	</div>				<!-- Separador -->				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">					<tbody>						<tr>							<td height="15" width="100%" style="font-size: 20px; line-height: 20px; padding: 0">&nbsp;</td>						</tr>					</tbody>				</table>	';
        $this->postTemplateHTML = '<!-- Redes sociales + ofertas -->				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">					<tbody>						<tr>							<td style="background: #fff; font-size: 0; padding: 0; text-align: center" align="center" bgcolor="#fff"><!--[if (gte mso 9)|(IE)]>                                    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">                                    <tr>                                    <td width="50%" valign="top">                                    <![endif]-->							<div style="display: inline-block; max-width: 300px; vertical-align: top; width: 100%">								<table width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">									<tbody>										<tr>											<td style="padding: 10px">											<table style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5; text-align: left; width: 100%">												<tbody>													<tr>														<td style="font-size: 13.2px; height: 40px; padding: 0; text-align: center" align="center">														Ent&eacute;rate de todo en <a target="_blank" title="Facebook" style="color: #444; font-weight: bold" href="~PROBE(206)~">Facebook</a> y 														<a target="_blank" title="Twitter" style="color: #444; font-weight: bold" href="~PROBE(207)~">Twitter</a></td>													</tr>												</tbody>											</table>											</td>										</tr>									</tbody>								</table>							</div>							<!--[if (gte mso 9)|(IE)]>                                    </td><td width="50%" valign="top">                                    <![endif]-->							<div style="display: inline-block; max-width: 300px; vertical-align: top; width: 100%">								<table width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">									<tbody>										<tr>											<td style="padding: 10px">											<table style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5; text-align: left; width: 100%">												<tbody>													<tr>														<td align="center" bgcolor="#00394c" width="280" style="padding: 0">															<a target="_blank" style="background: #00394c; border: 1px solid #00394c; color: #ffffff; display: block; font-family: Helvetica, Arial, sans-serif; font-size: 14.3px; font-weight: bold; letter-spacing: 1px; line-height: 20px; padding: 10px 8px; text-align: center; text-decoration: none; text-transform: uppercase; width: 260px" href="~PROBE(201)~">Ver m&aacute;s ofertas</a>														</td>													</tr>												</tbody>											</table>											</td>										</tr>									</tbody>								</table>							</div>							<!--[if (gte mso 9)|(IE)]>                                    </td>                                    </tr>                                    </table>                                    <![endif]--></td>						</tr>					</tbody>				</table>				<!-- Separador -->				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">					<tbody>						<tr>							<td height="15" width="100%" style="font-size: 20px; line-height: 20px; padding: 0">&nbsp;</td>						</tr>					</tbody>				</table>				<!-- App e Invita y gana -->				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">					<tbody>						<tr>							<td style="background: #fff; font-size: 0; padding: 0; text-align: center" align="center" bgcolor="#fff"><!--[if (gte mso 9)|(IE)]>                                    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">                                    <tr>                                    <td width="50%" valign="top">                                    <![endif]-->							<div style="display: inline-block; max-width: 300px; vertical-align: top; width: 100%">								<table width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">									<tbody>										<tr>											<td style="padding: 10px">											<table style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5; text-align: left; width: 100%">												<tbody>													<tr>														<td style="padding: 0"><a target="_blank" title="" style="display: block" href="~PROBE(208)~"><img width="280" alt="" style="border: 0; height: auto; max-width: 280px; width: 100%" src="http://multimedia.groupalia.com/static/img/NLiPhone/Banner_NL-App-ES-new.png" /> </a></td>													</tr>												</tbody>											</table>											</td>										</tr>									</tbody>								</table>							</div>							<!--[if (gte mso 9)|(IE)]>                                    </td><td width="50%" valign="top">                                    <![endif]-->							<div style="display: inline-block; max-width: 300px; vertical-align: top; width: 100%">								<table width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">									<tbody>										<tr>											<td style="padding: 10px">											<table style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5; text-align: left; width: 100%">												<tbody>													<tr>														<td colspan="3" style="padding: 0"><a target="_blank" title="" style="display: block" href="~PROBE(212)~"><img width="280" alt="" style="border: 0; height: auto; max-width: 280px; width: 100%" src="http://multimedia.groupalia.com/static/img/NLiPhone/Invita-y-gana-new.png" /> </a></td>													</tr>												</tbody>											</table>											</td>										</tr>									</tbody>								</table>							</div>							<!--[if (gte mso 9)|(IE)]>                                    </td>                                    </tr>                                    </table>                                    <![endif]--></td>						</tr>					</tbody>				</table>				<!-- Separador -->				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">					<tbody>						<tr>							<td height="15" width="100%" style="font-size: 20px; line-height: 20px; padding: 0">&nbsp;</td>						</tr>					</tbody>				</table>				<!-- Three column -->				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">					<tbody>						<tr>							<td style="background: #fff; font-size: 0; padding: 0; text-align: center" align="center" bgcolor="#fff"><!--[if (gte mso 9)|(IE)]>                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">                                    <tr>                                    <td width="200" valign="top">                                    <![endif]-->							<div style="display: inline-block; max-width: 200px; vertical-align: top; width: 100%">								<table width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">									<tbody>										<tr>											<td style="padding: 10px">											<table style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5; text-align: center; width: 100%">												<tbody>													<tr>														<td style="padding: 0"><img width="180" alt="" style="border: 0; height: auto; max-width: 180px; width: 100%" src="http://multimedia.groupalia.com/static/img/emails/newsletter/banner-footer/footer1.jpg" /></td>													</tr>												</tbody>											</table>											</td>										</tr>									</tbody>								</table>							</div>							<!--[if (gte mso 9)|(IE)]>                                    </td><td width="200" valign="top">                                    <![endif]-->							<div style="display: inline-block; max-width: 200px; vertical-align: top; width: 100%">								<table width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">									<tbody>										<tr>											<td style="padding: 10px">											<table style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5; text-align: center; width: 100%">												<tbody>													<tr>														<td style="padding: 0"><img width="180" alt="" style="border: 0; height: auto; max-width: 180px; width: 100%" src="http://multimedia.groupalia.com/static/img/emails/newsletter/banner-footer/footer2.jpg" /></td>													</tr>												</tbody>											</table>											</td>										</tr>									</tbody>								</table>							</div>							<!--[if (gte mso 9)|(IE)]>                                    </td><td width="200" valign="top">                                    <![endif]-->							<div style="display: inline-block; max-width: 200px; vertical-align: top; width: 100%">								<table width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">									<tbody>										<tr>											<td style="padding: 10px">											<table style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5; text-align: center; width: 100%">												<tbody>													<tr>														<td style="padding: 0"><img width="180" alt="" style="border: 0; height: auto; max-width: 180px; width: 100%" src="http://multimedia.groupalia.com/static/img/emails/newsletter/banner-footer/footer3.jpg" /></td>													</tr>												</tbody>											</table>											</td>										</tr>									</tbody>								</table>							</div>							<!--[if (gte mso 9)|(IE)]>                                    </td>                                    </tr>                                    </table>                                    <![endif]--></td>						</tr>					</tbody>				</table>				<!-- Footer -->				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">					<tbody>						<tr>							<td style="color: #707070; line-height: 1.275; padding: 20px 10px 0; text-align: left" align="left">								<div id="MASECTION" macontenteditable="FALSE" maconstraint="" maparameter="CONDICIONES" matype="" mahidediv="true">									</div>							</td>							</tr>						<tr>							<td style="color: #707070; line-height: 1.275; padding: 15px 10px 15px; text-align: left" align="left">								Este email ha sido enviado a <span style="color: #007ea7; text-decoration: underline">~MASTER.MAIL~</span> porque est&aacute;s suscrito a la Newsletter de Groupalia. <span style="color: #000">Si deseas gestionar tus suscripciones o darte de baja de la newsletter, </span> 							<a target="_blank" href="~PROBE(203)~" style="color: #007ea7; text-decoration: underline"> haz click aqu&iacute;</a>. De acuerdo a la Ley 15/1999 sobre Protecci&oacute;n de Datos personales, te informamos que tu direcci&oacute;n de e-mail forma parte de los ficheros de Groupalia Compra Colectiva, S.L., pudiendo ejercer en cualquier momento tus derechos de acceso, rectificaci&oacute;n, oposici&oacute;n y cancelaci&oacute;n a trav&eacute;s de tu &ldquo;&aacute;rea de usuario&rdquo;, o bien dirigi&eacute;ndote por escrito a Groupalia Compra Colectiva, S.L. C/ Foment, 8, Sant Just Desvern 08960 Barcelona Espa&ntilde;a. Si has recibido este mensaje por equivocaci&oacute;n, por favor, destr&uacute;yelo y notif&iacute;calo por correo electr&oacute;nico. Gracias. Planes de Ocio, Belleza, Escapadas, Viajes y Productos</td>						</tr>						<tr>							<td style="color: #707070; line-height: 1.275; padding: 0 10px 15px; text-align: left" align="left">								<a target = "_blank" title="" style="color: #707070; text-decoration: underline" href="~PROBE(209)~">Condiciones de uso</a>&nbsp;|&nbsp;								<a target = "_blank" title="" style="color: #707070; text-decoration: underline" href="~PROBE(210)~">Pol&iacute;tica de privacidad</a>&nbsp;|&nbsp;								<a target = "_blank" title="" style="color: #707070; text-decoration: underline" href="~PROBE(211)~">Atenci&oacute;n al cliente</a><br />								<br />								Copyright &copy; 2016 Groupalia Compra Colectiva, S.L. Derechos reservados.								<img src="https://pixel.monitor1.returnpath.net/pixel.gif?r=f76b6f53455cdd666110fb400ec0734760049c0f&NL=express&segment_code=~GP_NL_DAILY.SEGMENT_CODE~" width="1" height="1" />							</td>						</tr>					</tbody>				</table>				</td>			</tr>		</tbody>	</table>	<!--[if (gte mso 9)|(IE)]>            </td>            </tr>            </table>            <![endif]--></div></center>';
        $this->separadorHTML = '				<!-- Separador -->				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">					<tbody>						<tr>							<td height="15" width="100%" style="font-size: 20px; line-height: 20px; padding: 0">&nbsp;</td>						</tr>					</tbody>				</table>';
        $this->preTwoColumsHTML = '				<!-- TwoColumns - El bucle es desde el primer <tr> -->
							<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">
								<tr>
									<td style="background: #fff; font-size: 0; padding: 0; text-align: center" align="center" bgcolor="#fff">
										<!--[if (gte mso 9)|(IE)]><table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5"><tr><td width="50%" valign="top"><![endif]-->
											<!--código de deals 2 columnas-->';


        $this->postTwoColumsHTML = '<!--fin código de deals 2 columnas-->												
									</td>
								</tr>
							</table>';

        $this->selligentSensor = 'mktc=_ESGPNLDNLNCOOTRGEN~SYSTEM.CAMPAIGNID~NEMAOTOTHR00N0OTGENNA&utm_campaign=~SYSTEM.CAMPAIGNID~&utm_content=~MASTER.CODE~&utm_medium=email&utm_source=selligent&email=~MASTER.MAIL~&date=~SYSTEM.YEAR~~(RIGHT("0" & SYSTEM.MONTH,2))~~(RIGHT("0" & SYSTEM.DAY,2))~';
    }

    function setMailSelligentBySkuArray($skuArray, $DoctrineEntityManager) {
        $LineaFeedArray = $this->getLineaFeedArrayBySkuArray($skuArray, $DoctrineEntityManager);
        $LineaFeedTemp1 = null;
        $LineaFeedTemp2 = null;
        $i = 0;
        $flag_impar = false;
        if (count($LineaFeedArray) == 0)
            throw new \Exception('NoLineaFeedInCaspas');
        foreach ($LineaFeedArray as $key => $LineaFeed) {
            if ($i % 2 == 0)
                $LineaFeedTemp1 = $LineaFeed;
            $flag_impar = false;
            if ($i % 2 != 0) {
                $LineaFeedTemp2 = $LineaFeed;
                $this->mail = $this->mail . $this->getTwoColumsHTML($LineaFeedTemp1, $LineaFeedTemp2);
                $LineaFeedTemp1 = null;
                $LineaFeedTemp2 = null;
                $flag_impar = true;
            }
            $i++;
        }
        if (!$flag_impar) {
            $this->mail = $this->mail . $this->getTwoColumsHTML($LineaFeedTemp1, null, true);
        }
        $this->mail = $this->mail . $this->separadorHTML;
    }

    private function getTwoColumsHTML($LineaFeed1, $LineaFeed2, $flagDealComodinImpar = false) {
        if (!$flagDealComodinImpar) {
            $twoColumsHTML = $this->preTwoColumsHTML . $this->getDeal($LineaFeed1) . $this->getDeal($LineaFeed2) . $this->postTwoColumsHTML;
        } else {
            $twoColumsHTML = $this->preTwoColumsHTML . $this->getDeal($LineaFeed1) . $this->getDealComodinImpar() . $this->postTwoColumsHTML;
        }

        return $twoColumsHTML;
    }

    private function getDealComodinImpar() {
        $deal = '<div style="display: inline-block; max-width: 300px; vertical-align: top; width: 100%">
	<table width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">
		<tbody>
			<tr>
				<td style="padding: 10px">
					<table style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5; text-align: left; width: 100%">
						<tbody>
							<tr>
								<td style="padding: 0">
									<a target="_blank" href="http://es.groupalia.com/ofertas-tienda/?' . $this->selligentSensor . '" title="" style="display: block">
										<img src="http://multimedia.groupalia.com/static/img/securityBanners/securityBannerRetail-groupalia.jpg" width="280" alt="" style="border: 0; height: auto; max-width: 280px; width: 100%">
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>';
        return $deal;
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

    function getMail() {
        return $this->mail;
    }

    /**
     * 
     * @param LineaFeed $LineaFeed
     * @return string
     */
    private function getDeal($LineaFeed) {
        $image = $LineaFeed->getImage();
        $shortTitle = $this->cortaStringLargo($LineaFeed->getShortTitle());
        $address = $this->cortaStringLargo($LineaFeed->getAddressInGeoLocations());
        $discount = $LineaFeed->getDiscountInPrince();
        $price = $LineaFeed->getPriceInPrince();
        $specialPrice = $LineaFeed->getSpecialPriceInPrince();
        $canonicalUrl = $LineaFeed->getCanonicalUrl();
        $sku = $LineaFeed->getSku();
        $dealTemp = '										<!-- DEAL -->
										<div style="display: inline-block; max-width: 300px; vertical-align: top; width: 100%">
											<table width="100%" style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5">
												<tr>
													<td style="padding: 10px">
														<table style="border-spacing: 0; color: #707070; font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.5; text-align: left; width: 100%">
															<tr>
																<td colspan="3" style="padding: 0">
																	<a href="' . $canonicalUrl . '?' . $this->selligentSensor . '" target="_blank"  title="" style="display: block">
																		<img src="' . $image . '" width="280" alt="" style="border: 0; height: 214px; max-width: 280px; width: 100%" />
																	</a>
																</td>
															</tr>
															<tr>
																<td colspan="3" style="height: 50px; padding: 10px 0 0; vertical-align: top" valign="top">
																	<a href="http://em.groupalia.com/optiext/optiextension.dll?ID=xugH%2BbI6Yedg9GRlQqi6PkcoFIqFgdzaE22axRS3qGndwaMLgrLpTues7mf0yP_A5Dw3R1Rgfei2QvM29EN46nsoBpxxxG" target="_blank"  title="" style="color: #444; font-size: 15px; font-weight: bold; line-height: 1.35; text-decoration: none">
' . $shortTitle . '
																	</a>
																</td>
															</tr>
															<tr>
																<td colspan="3" style="height: 50px; vertical-align: top; font-size: 13.2px; padding: 5px 0 0" valign="top">
																	<img src="http://multimedia.groupalia.com/static/img/emails/newsletter/transaccionales_2014/newdesign/poi-grey.jpg" alt="Poi" style="border: 0; vertical-align: text-bottom; width: 21px" />
' . $address . '																	
																</td>
															</tr>
															<tr>
																<td style="color: #007ea7; font-size: 20px; font-weight: bold; padding: 5px 0; width: 115px; min-width: 115px">
 ' . $discount . '% dto.

																</td>
																<td style="font-size: 14.3px; text-align: center; padding: 10px 0 5px; text-decoration: line-through; width: 75px" align="center">
 ' . $price . '€
																</td>
																<td style="color: #444; font-size: 20px; font-weight: bold; padding: 5px 0">' . $specialPrice . '€  </td>
																<td/>
																<td/>
															</tr>
															<tr>
																<td colspan="3" align="center" bgcolor="#007ea7" width="280" style="padding: 0">
																	<a href="' . $canonicalUrl . '?' . $this->selligentSensor . '" target="_blank"  style="background: #007ea7; border: 1px solid #007ea7; color: #ffffff; display: block; font-family: Helvetica, Arial, sans-serif; font-size: 14.3px; font-weight: bold; letter-spacing: 1px; line-height: 20px; padding: 10px 8px; text-align: center; text-decoration: none; text-transform: uppercase; width: 260px">Ver Oferta</a>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</div>
										<!-- FIN DEAL -->
										<!-- FIN MAITEM -->
										<!-- CODIGO ENTRE DEALS
 [if (gte mso 9)|(IE)]></td><td width="50%" valign="top"><![endif]-->';
        return $dealTemp;
    }

    private function cortaStringLargo($string){
        $string = substr($string,0,81);
        return $string;
    }

}
