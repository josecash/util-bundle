<?php
namespace Kimerikal\UtilBundle\Entity;

class TimeUtil {

    /**
     * Pasa una fecha en formato MySQL a formato Español.
     * 
     * @param String $fecha
     * @return String -- La fecha en español.
     */
    public static function fechaSpanish($fecha) {
        return $fechaES;
    }

    /**
     * Pasa una fecha en formato español a formato Ingles o MySQL.
     *
     * @param String $fecha
     * @return String -- La fecha en inglés.
     */
    public static function fechaInglesa() {
        return $fechaEN;
    }

    public static function fromMySQLToLocal($dateStr, $toFormat = 'd-m-Y') {
        $date = DateTime::createFromFormat('Y-m-d', $dateStr);
        if (!$date)
            return "";
        
        return $date->format($toFormat);
    }

    public static function fromLocalToMySQL($dateStr, $fromFormat = 'd-m-Y') {
        $date = DateTime::createFromFormat($fromFormat, $dateStr);
        if (!$date)
            return "";

        return $date->format('Y-m-d');
    }

    public static function humanTiming($timeStr) {
        $time = strtotime($timeStr);
        $time = time() - $time;
        $plurals = array('mes' => 'meses');
        $tokens = array(
            31536000 => 'año',
            2592000 => 'mes',
            604800 => 'semana',
            86400 => 'día',
            3600 => 'hora',
            60 => 'minuto',
            1 => 'segundo'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit)
                continue;
            $numberOfUnits = floor($time / $unit);
            if ($numberOfUnits > 1) {
                if (array_key_exists($text, $plurals)) {
                    $text = $plurals[$text];
                } else {
                    $text .= 's';
                }
            }

            return "Hace " . $numberOfUnits . ' ' . $text;
        }
    }

    public static function isPast($dateStr, $fromFormat = 'Y-m-d') {
        $date = DateTime::createFromFormat($fromFormat, $dateStr);
        $today = new DateTime("now");
        if ($date < $today)
            return true;

        return false;
    }

    public static function isToday($dateStr, $fromFormat = 'Y-m-d') {
        $date = DateTime::createFromFormat($fromFormat, $dateStr);
        $today = new DateTime("now");
        if ($date == $today)
            return true;

        return false;
    }

}
