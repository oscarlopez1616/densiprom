<?php
require_once('LocPhysicalAdwordsRedirectorService.php');
$LocPhysicalAdwordsRedirectorService = new LocPhysicalAdwordsRedirectorService($_GET["url_redirect_without_slug_city"],$_GET["loc_physical_adwords"]);
header("HTTP/1.1 303 See Other");
header("Location: ".$LocPhysicalAdwordsRedirectorService->getUrlRedirectWithSlugCityLb());
