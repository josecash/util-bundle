<?php

namespace OfCoding\UtilBundle\Controller;

use OfCoding\UtilBundle\Controller\UtilController;
use OfCoding\UtilBundle\Model\LangInterface;
use Symfony\Component\HttpFoundation\Request;
use OfCoding\UtilBundle\Entity\BrowserUtil;

class LangController extends UtilController implements LangInterface {

    public function checkLang(Request $request) {
        $cookieLang = $request->cookies->get('lang');
        $locale = $request->getLocale();

        if (!empty($cookieLang) && $cookieLang != $locale) {
            $route = $request->get('_route');
            return $this->generateUrl($route . '.' . $cookieLang);
        } else if (empty($cookieLang)) {
            $resp = new Response();
            $resp->headers->setCookie(new Cookie('lang', $locale, 0, '/', null, false, false));
            $resp->send();
        }
        
        return null;
    }

}
