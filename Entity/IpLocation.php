<?php

namespace Kimerikal\UtilBundle\Entity;

final class IpLocation {

    const API_KEY = '5586e89ed2df17f4691916decdecb021efec655649b70536516b4a4fa10fdfda';
    const PRECISION_CITY = 'ip-city';
    const PRECISION_COUNTRY = 'ip-country';
    const SERVICE = 'api.ipinfodb.com';
    const SERVICE_VERSION = 'v3';
    const FORMAT = 'xml';

    protected $errors;
    protected $precion;
    protected $country;
    protected $city;

    public function __construct($host, $precision = self::PRECISION_CITY) {
        $this->host = $host;
        $this->precion = $precision;
        $this->errors = array();
        
        if ($precision == self::PRECISION_CITY) 
            $this->getCity();
        else 
            $this->getCountry();
    }

    public function getError() {
        return implode("\n", $this->errors);
    }

    public function getCountry() {
        if (empty($this->country))
            $this->country = $this->getResult(self::PRECISION_COUNTRY);

        return $this->country;
    }

    public function getCity() {
        if (empty($this->city))
            $this->city = $this->getResult(self::PRECISION_CITY);
        
        return $this->city;
    }

    private function getResult($precision) {
        $ip = \gethostbyname($this->host);

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $xml = \file_get_contents('http://' . self::SERVICE . '/' . self::SERVICE_VERSION . '/' . $precision . '/?key=' . self::API_KEY . '&ip=' . $ip . '&format=' . self::FORMAT);
            if (\get_magic_quotes_runtime()) {
                $xml = stripslashes($xml);
            }

            try {
                $response = new \SimpleXMLElement($xml);

                foreach ($response as $field => $value) {
                    $result[(string) $field] = (string) $value;
                }

                return $result;
            } catch (Exception $e) {
                $this->errors[] = $e->getMessage();
                return;
            }
        }

        $this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
        return;
    }

}
