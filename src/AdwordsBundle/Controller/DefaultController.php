<?php

namespace AdwordsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AdwordsBundle\Services\LocPhysicalAdwordsRedirectorService;

class DefaultController extends Controller
{
    /**
     * @Route("/adwords/utils/")
     */
    public function indexAction(Request $request)
    {
        $LocPhysicalAdwordsRedirectorService = new LocPhysicalAdwordsRedirectorService($request->query->get('url_redirect_without_slug_city'),$request->query->get('loc_physical_adwords'));
        return $this->redirect($LocPhysicalAdwordsRedirectorService->getUrlRedirectWithSlugCityLb(), 301);
    }
}
