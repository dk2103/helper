<?php
/**
 * @link      https://github.com/dk2103/helper
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Helper;

use Zend\Config\Exception;
use Zend\Config\Reader\Ini;

/*
 * Class to read config
 */
class ConfigReader
{

   /*
    * Returns an array of configurations or a single configuration.
    * Usage: add parameters to move the subtree down.
    * Example: read('ldap', 'server', 'host') returns host configuration of specific ldap server
    */
    public static function read()
    {
        if (! self::isConfigurationValid())
            return null;
        $reader = new Ini();
        $config = $reader->fromFile(self::getConfigFile());
        $args = func_get_args();
        $args = array_reverse($args);
        $count = func_num_args();
        return self::callback($config, $args, $count - 1);
    }

    private function callback($config, $args, $num)
    {
        if ($num == - 1) {
            return $config;
        }

        $arg = $args[$num];
        return self::callback($config[$arg], $args, ($num - 1));
    }

    /*
    public static function getDefaultConfig()
    {
        $reader = new Ini();
        $config = $reader->fromFile(self::getConfigFile() . '.dist');
        $args = func_get_args();
        $args = array_reverse($args);
        $count = func_num_args();
        return self::callback($config, $args, $count - 1);
    }
   */
    public static function isConfigurationValid()
    {
        $reader = new Ini();
        try {
            $reader->fromFile(self::getConfigFile());
            return true;
        } catch (\Exception $e) {
            return false;
        } catch (Exception $e) {
            return false;
        } catch (\Zend\Config\Exception\RuntimeException $e) {
            return false;
        }
    }

    public static function getConfigFile()
    {
        return dirname(__FILE__) . "/../../../../config/meiko.config.ini";
    }
}