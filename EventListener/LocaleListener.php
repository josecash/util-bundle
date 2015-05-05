<?php

namespace OfCoding\UtilBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use OfCoding\UtilBundle\Controller\LangController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LocaleListener implements EventSubscriberInterface {

    private $defaultLocale;
    private $router;

    public function __construct($router, $defaultLocale = 'es') {
        $this->router = $router;
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelController(FilterControllerEvent $event) {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        $control = $controller[0];
        if ($control instanceof LangController) {
            $url = $control->checkLang($event->getRequest());
            if (!is_null($url)) {
                $event->setController(function() use ($url) {
                    return new RedirectResponse($url);
                });
            }
        }
    }

    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        $locale = $request->attributes->get('_locale');
        if ($locale) {
            $request->getSession()->set('_locale', $locale);
        } else {
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

    public static function getSubscribedEvents() {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
        );
    }

}
