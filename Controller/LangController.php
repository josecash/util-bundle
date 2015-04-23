<?php

namespace OfCoding\UtilBundle\Controller;

use OfCoding\UtilBundle\Controller\UtilController;
use OfCoding\UtilBundle\Model\LangInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

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
            $response = new Response();
            $response->headers->setCookie(new Cookie('lang', $locale, 0, '/', null, false, false));
            $response->send();
        }

        return $url;
    }

}
