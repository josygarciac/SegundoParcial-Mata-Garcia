<?php
/**
 * LoggingService.php

 */

namespace App\Services;

class LoggingService
{
    private function __construct() { }

    /**
     * Persist an string in the error log
     *
     * @param string $message
     * @param string $file opcional, recomendado usar __FILE__
     * @param string $line opcional, recomendado usar __LINE__
     */
    public static function log($message, $file = "", $line = "") {
        self::doLog("\n$file: $line\n" . $message);
    }

    /**
     * Persist a variable in the error log
     *
     * @param $message
     * @param string $file opcional, recomendado usar __FILE__
     * @param string $line opcional, recomendado usar __LINE__
     */
    public static function logVariable($message, $file = "", $line = "") {
        self::doLog("\n$file: $line\n" . print_r($message, true));
    }

    /**
     * Persiste a message in the error log
     *
     * @param string $message
     */
    private static function doLog($message) {
        $time = self::getTime();
        error_log("---- \n$time $message", 3, "error.log");
    }

    /**
     * Return an string with the current hour/date
     *
     * @return string
     */
    private static function getTime() {
        $time = new \DateTime("now", new \DateTimeZone("America/Costa_Rica"));
        return $time->format("d/m/y H:i:s");
    }
}
  