<?php

namespace Kimerikal\UtilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UtilController extends Controller {

    const DEFAULT_MAIL = 'mailer_user';
    const FRONT_ENV = 'fontend';
    const BACK_ENV = 'backend';

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

        return $this->get('mailer')->send($message);
    }

    protected function parameter($name) {
        return $this->container->getParameter($name);
    }

    protected function userGranted($role) {
        return $this->get('security.context')->isGranted($role);
    }

    protected function getFullUrl(Request $request, $path = '', $clear = array('/app_dev.php')) {
        $url = $request->getUriForPath($path);
        if (!empty($clear)) {
            if (!is_array($clear))
                $clear = array($clear);

            foreach ($clear as $r)
                $url = str_replace($r, '', $url);
        }

        return $url;
    }

    /**
     * 
     * @param type $key - if empty returns session object
     * @param type $value - if null and not empty $key removes var
     * @return type
     */
    protected function session($key = null, $value = null) {
        if (!empty($key) && !is_null($value)) {
            $this->get('session')->set($key, $value);
        } else if (!empty($key)) {
            $this->get('session')->remove($key);
        }

        return $this->get('session');
    }

    /**
     * Get global session var value if set, depending on parameters, compare 
     * or check only if var is set as well.
     * 
     * @param type $key - session variable key
     * @param type $default - default value to return
     * @param type $issetOnly - if true just check if variable is set
     * @param type $value - if not null compare session value with this value.
     * @return mixed
     */
    protected function checkSession($key = null, $default = false, $issetOnly = false, $value = null) {
        if (empty($key))
            return null;

        if (!$this->get('session')->has($key)) {
            return $default;
        } else if ($issetOnly) {
            return true;
        }

        if (!is_null($value)) {
            if ($this->get('session')->get($key) == $value)
                return true;
            else
                return false;
        }

        return $this->get('session')->get($key, $default);
    }

    protected function environment() {
        return $this->checkSession('user_environment', 'frontend');
    }

    protected function setEnvironment($environment = self::ADMIN_ENV) {
        return $this->session('user_environment', $environment);
    }

}
