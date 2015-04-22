<?php

namespace OfCoding\UtilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OfCoding\UtilBundle\Entity\BrowserUtil;

class UtilController extends Controller {
    protected $browser;
    
    public function __construct() {
        $this->browser = new BrowserUtil();
    }

    protected function doctrine() {
        return $this->getDoctrine()->getManager();
    }

    protected function doctrineRepo($repo) {
        return $this->getDoctrine()->getManager()->getRepository($repo);
    }

    protected function flashMsg($type, $msg) {
        $this->get('session')->getFlashBag()->add($type, $msg);
    }

    protected function mailing($subject, $from, $to, $view) {
        $message = \Swift_Message::newInstance();
        $message->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($view, 'text/html');

        $this->get('mailer')->send($message);
    }

}
