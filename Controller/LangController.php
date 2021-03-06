<?php

namespace Kimerikal\UtilBundle\Controller;

use Kimerikal\UtilBundle\Controller\UtilController;
use Kimerikal\UtilBundle\Model\LangInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Kimerikal\UtilBundle\Entity\IpLocation;
use Kimerikal\UtilBundle\Entity\BrowserUtil;

/**
 * TODO: Hacer array de idiomas permitidos en parametros generales.
 */
class LangController extends UtilController implements LangInterface {

    public function checkLang(Request $request) {
        $url = null;
        $cookieLang = $request->cookies->get('lang');
        $locale = $request->getLocale();

        if (!empty($cookieLang) && $cookieLang != $locale) {
            try {
                $route = $request->get('_route');
                $url = $this->generateUrl($route . '.' . $cookieLang);
            } catch (RouteNotFoundException $e) {
                $url = null;
            }
        } else if (empty($cookieLang)) {
            $this->chooseLang($locale, $request->getClientIp());
            $response = new Response();
            $response->headers->setCookie(new Cookie('lang', $locale, 0, '/', null, false, false));
            $response->send();
        }

        return $url;
    }

    private function chooseLang(&$locale, $ip) {
        $allowedLangs = array('es', 'en', 'fr', 'de');
        $ipLang = $locale;

        if (!empty($ip)) {
            $ipLoc = new IpLocation($ip, IpLocation::PRECISION_COUNTRY);
            $ipCountry = $ipLoc->getCountry();
            if (!empty($ipCountry) && isset($ipCountry['countryCode']))
                $ipLang = strtolower($ipCountry['countryCode']);
        }
        
        $browser = new BrowserUtil();
        $browserLang = $browser->getLang();
        if ($browserLang == $ipLang && in_array($ipLang, $allowedLangs))
            $locale = $ipLang;
        else if (in_array($browserLang, $allowedLangs))
            $locale = $browserLang;
    }

}
