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

    private static $instance = null;

    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new Log();
        }
        return self::$instance;
    }

    private function __construct()
    {}

    public function trace(string $key, string $message)
    {
        if (! isset($this->logger))
            $this->loadConfig();
        $this->logger->trace($this->format($key, $message));
    }

    public function debug(string $key, string $message)
    {
        if (! isset($this->logger))
            $this->loadConfig();
        $this->logger->debug($this->format($key, $message));
    }

    public function info(string $key, string $message)
    {
        if (! isset($this->logger))
            $this->loadConfig();
        $this->logger->info(self::format($key, $message));
    }

    public function warn(string $key, string $message)
    {
        if (! isset($this->logger))
            $this->loadConfig();
        $this->logger->warn(self::format($key, $message));
    }

    public function error(string $key, string $message)
    {
        if (! isset($this->logger))
            $this->loadConfig();
        $this->logger->error(self::format($key, $message));
    }

    public function fatal(string $key, string $message)
    {
        if (! isset($this->logger))
            $this->loadConfig();
        $this->logger->fatal(self::format($key, $message));
    }

    private function loadConfig()
    {
        $config = ConfigReader::getConfigFile();
        $configFile = dirname($config) . '/logger.xml';

        if (! $configFile) {
            $this->loadTempalteConfig();
        } else
            Logger::configure($configFile);

        $logLevel = ConfigReader::read('logging', 'environment');
        if (! $logLevel) {
            $this->logger = Logger::getLogger('development');
            $this->logger->info("logging.environment missing in " . $config . ". development configuration used");
        } else
            $this->logger = Logger::getLogger($logLevel);
        // \Zend\Debug\Debug::dump($this->logger);
    }

    private function loadTempalteConfig()
    {
        $template = dirname(__FILE__) . "/../templates/template.xml";
        if (! file_exists($template)) {
            throw new \Exception("Keine Konfiguration und kein default template vorhanden in " . static::class);
        }

        Logger::configure();
    }

    private function format($key, $message)
    {
        return '| ' . $key . ' | ' . $message;
    }
}