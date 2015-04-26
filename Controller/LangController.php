<?php

namespace OfCoding\UtilBundle\Controller;

use OfCoding\UtilBundle\Controller\UtilController;
use OfCoding\UtilBundle\Model\LangInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use OfCoding\UtilBundle\Entity\IpLocation;
use OfCoding\UtilBundle\Entity\BrowserUtil;

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
            $this->chooseLang($locale);
            $response = new Response();
            $response->headers->setCookie(new Cookie('lang', $locale, 0, '/', null, false, false));
            $response->send();
        }

        return $url;
    }

    private function chooseLang(&$locale) {
        $allowedLangs = array('es', 'en', 'fr', 'de');
        $ipLang = $locale;
        $ip = $request->getClientIp();
        $ipLoc = new IpLocation($ip, IpLocation::PRECISION_COUNTRY);
        if (!empty($ipLoc)) {
            $ipCountry = $ipLoc->getCountry();
            if (!empty($ipCountry))
                $ipLang = strtolower($ipCountry['contryCode']);
        }

        $browser = new BrowserUtil();
        $browserLang = $browser->getLang();
        if ($browserLang == $ipLang && in_array($ipLang, $allowedLangs))
            $locale = $ipLang;
        else if (in_array($browserLang, $allowedLangs))
            $locale = $browserLang;
    }

}
