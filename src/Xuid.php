<?php

namespace Xuid;

use Ramsey\Uuid\Uuid;
use RuntimeException;

class Xuid
{
    protected static $map = [
        '+' => '-',
        '/' => '_',
    ];

    protected static $alphaNumericOnly = false;

    public static function forceAlphaNumeric($force = true)
    {
        self::$alphaNumericOnly = $force;
    }

    public static function setMap($map)
    {
        self::$map = $map;
    }

    public static function isValidUuid($uuid)
    {
        if (preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $uuid)) {
            return true;
        }
        return false;
    }
    
    public static function isValidXuid($xuid)
    {
        $uuid = self::decode($xuid);
        return self::isValidUuid($uuid);
    }
    
    
    public static function getXuid()
    {
        do {
            $uuid = self::getUuid();
            $xuid = self::encode($uuid);
        } while (self::$alphaNumericOnly && !ctype_alnum($xuid));
        return $xuid;
    }
    
    public static function getUuid()
    {
        $uuid = Uuid::uuid4();
        return $uuid;
    }
    
    public static function base64UrlEncode($data)
    {
        $str = rtrim(base64_encode($data), '=');
        foreach (self::$map as $from => $to) {
            $str = str_replace($from, $to, $str);
        }
        return $str;
    }
    
    public static function base64UrlDecode($data)
    {
        $str = strtr($data, '-_', '+/');
        foreach (self::$map as $from => $to) {
            $str = str_replace($to, $from, $str);
        }
        $str = base64_decode(str_pad($str, strlen($str) % 4, '=', STR_PAD_RIGHT));
       
        return $str;
    }
    
    public static function encode($uuid)
    {
        if (!self::isValidUuid($uuid)) {
            throw new RuntimeException("Invalid UUID");
        }
        $uuid = str_replace('-', '', $uuid);
        $bin = hex2bin($uuid);
        $xuid = self::base64UrlEncode($bin);
        return $xuid;
    }
    
    public static function decode($xuid)
    {
        $bin = self::base64UrlDecode($xuid);
        $uuid = bin2hex($bin);
        if (strlen($uuid)!=32) {
            throw new RuntimeException("Invalid XUID");
        }
        
        $out = '';
        $out .= substr($uuid, 0, 8) . '-';
        $out .= substr($uuid, 8, 4) . '-';
        $out .= substr($uuid, 12, 4) . '-';
        $out .= substr($uuid, 16, 4) . '-';
        $out .= substr($uuid, 20, 12);
        
        if (!self::isValidUuid($out)) {
            throw new RuntimeException("Invalid XUID");
        }

        return $out;
    }
    
}
