<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Helper;

class CryptoHelper
{

    public static function encrpyt($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ConfigReader::read('crypto', 'options'));
    }

    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}