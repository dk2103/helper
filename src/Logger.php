<?php
/**
 * @link      https://github.com/dk2103/helper
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Helper;

use Logger;
require_once 'vendor/apache/log4php/main/php/Logger.php';

class Log
{

    private $logger;

    private $isLoaded;

    public function trace(string $key, string $message)
    {
        if (! $isLoaded)
            $this->loadConfig();
        $logger->trace($this->format($key, $message));
    }

    public function debug(string $key, string $message)
    {
        if (! $isLoaded)
            $this->loadConfig();
        $logger->debug($this->format($key, $message));
    }

    public function info(string $key, string $message)
    {
        if (! $isLoaded)
            $this->loadConfig();
        $logger->info(self::format($key, $message));
    }

    public function warn(string $key, string $message)
    {
        if (! $isLoaded)
            $this->loadConfig();
        $logger->warn(self::format($key, $message));
    }

    public function error(string $key, string $message)
    {
        if (! $isLoaded)
            $this->loadConfig();
        $logger->error(self::format($key, $message));
    }

    public function fatal(string $key, string $message)
    {
        if (! $isLoaded)
            $this->loadConfig();
        $logger->fatal(self::format($key, $message));
    }

    private function loadConfig()
    {
        if (isset(ConfigReader::read('logging', 'file'))) {
            Logger::configure(ConfigReader::read('logging', 'file'));
        } else
            loadTempalteConfig();

        self::$logger = Logger::getLogger('bla');
        self::$isLoaded = true;
    }

    private function loadTempalteConfig()
    {
        $template = dirname(__FILE__) . "template.xml";
        if (! file_exists($tempalte)) {
            throw new \Exception("Keine Konfiguration und kein default template vorhanden in " . static::class);
        }

        Logger::configure();
    }

    private static function format($key, $message)
    {
        return '| ' . $key . ' | ' . $message;
    }
}