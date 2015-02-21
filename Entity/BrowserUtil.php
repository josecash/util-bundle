<?php

namespace OfCoding\UtilBundle\Entity;

class BrowserUtil {

    const FIREFOX = "firefox";
    const CHROME = "chrome";
    const IE = "IE";
    const SAFARI = "safari";
    const OPERA = "Opera";
    const LAN_ESP = "Es-es";
    const LAN_ENG = "En-en";

    private $agent;
    private $browser;
    private $broVersion;
    private $browserArr;
    private $idioma;
    private $so;
    public $isPhone = false;
    public $isTablet = false;
    public $isLinux = false;
    public $isWindows = false;
    public $isMac = false;
    public $isAndroid = false;
    public $isIos = false;
    public $isWinMobile = false;
    public $isBlackBerry = false;

    public function __construct() {
        $this->browserArr = array(
            'Opera' => 'Opera',
            'firefox' => '(Firebird)|(Firefox)',
            'chrome' => 'Chrome',
            'safari' => 'Safari',
            'Galeon' => 'Galeon',
            'Mozilla' => 'Gecko',
            'MyIE' => 'MyIE',
            'Lynx' => 'Lynx',
            'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
            'Konqueror' => 'Konqueror',
            'IE' => '(MSIE [4-9]+\.[0-9]+)'
        );

        $this->agent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_STRING);
        $this->getLang();
        $this->getBrowser($this->agent);
        $this->getSO($this->agent);
    }

    public function getLang() {
        if (empty($this->idioma)) {
            $idiomas = explode(";", filter_input(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE'));
            if (is_array($idiomas)) {
                $lang = explode(',', $idiomas[0]);
                if (is_array($lang))
                    $this->idioma = $lang[0];
            }
        }

        return $this->idioma;
    }

    public function getBrowser($user_agent) {
        if (empty($this->browser)) {
            foreach ($this->browserArr as $navegador => $pattern) {
                if (preg_match("/" . $pattern . "/i", $user_agent)) {
                    $this->browser = $navegador;
                    break;
                }
            }

            if (empty($this->browser))
                $this->browser = 'Desconocido';
        }

        return $this->browser;
    }

    public function getVersion($user_agent) {
        if (empty($this->broVersion)) {
            if ($this->browser == self::CHROME) {
                
            } else if ($this->browser == self::FIREFOX) {
                
            }
        }

        return $this->broVersion;
    }

    public function getSO($user_agent) {
        if (stripos($user_agent, "Android") !== false) {
            $this->so = "Android";
            $this->isAndroid = true;
            $this->isPhone = true;
        } else if (stripos($user_agent, "iphone") !== false) {
            $this->so = "IOS";
            $this->isPhone = true;
            $this->isIos = true;
        } else if (stripos($user_agent, "blackberry") !== false) {
            $this->so = "blackberry";
            $this->isPhone = true;
            $this->isBlackBerry = true;
        } else if (stripos($user_agent, "Windows Phone") !== false) {
            $this->so = "Windows Phone";
            $this->isPhone = true;
            $this->isWinMobile = true;
        } else if (stripos($user_agent, "linux") !== false) {
            $this->so = "Linux";
            $this->isLinux = true;
        } else if (stripos($user_agent, "Windows") !== false) {
            $this->so = "Windows";
            $this->isWindows = true;
        } else if (stripos($user_agent, "Macintosh") !== false) {
            $this->so = "Macintosh";
            $this->isMac = true;
        } else if (stripos($user_agent, "ipad") !== false) {
            $this->so = "IOS";
            $this->isIos = true;
            $this->isTablet = true;
        }

        return $this->so;
    }

}
