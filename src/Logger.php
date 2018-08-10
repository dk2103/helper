<?php
/**
 * @link      https://github.com/dk2103/helper
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Helper;

use Logger;

class Log
{

    private $logger;

    private $isLoaded;

    public function __construct()
    {
        $this->isLoaded = false;
        $logger = null;
    }

    public function trace(string $key, string $message)
    {
        if (! $this->isLoaded)
            $this->loadConfig();
        $this->logger->trace($this->format($key, $message));
    }

    public function debug(string $key, string $message)
    {
        if (! $this->isLoaded)
            $this->loadConfig();
        $this->logger->debug($this->format($key, $message));
    }

    public function info(string $key, string $message)
    {
        if (! $this->isLoaded)
            $this->loadConfig();
        $this->logger->info(self::format($key, $message));
    }

    public function warn(string $key, string $message)
    {
        if (! $this->isLoaded)
            $this->loadConfig();
        $this->logger->warn(self::format($key, $message));
    }

    public function error(string $key, string $message)
    {
        if (! $this->isLoaded)
            $this->loadConfig();
        $this->logger->error(self::format($key, $message));
    }

    public function fatal(string $key, string $message)
    {
        if (! $this->isLoaded)
            $this->loadConfig();
        $this->logger->fatal(self::format($key, $message));
    }

    private function loadConfig()
    {
        $config = ConfigReader::read('logging', 'file');

        if (! $config) {
            Logger::configure($config);
        } else
            $this->loadTempalteConfig();

        $this->logger = Logger::getLogger('bla');
        $this->isLoaded = true;
    }

    private function loadTempalteConfig()
    {
        $template = dirname(__FILE__) . "/../templates/template.xml";
        if (! file_exists($template)) {
            echo $template;
            throw new \Exception("Keine Konfiguration und kein default Template vorhanden in " . static::class);
        }

        Logger::configure();
    }

    private function format($key, $message)
    {
        return '| ' . $key . ' | ' . $message;
    }
}