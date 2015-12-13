<?php

namespace Xuid;

use Ramsey\Uuid\Uuid;
use RuntimeException;

class Xuid
{
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
        $uuid = self::getUuid();
        return self::encode($uuid);
    }
    
    public static function getUuid()
    {
        $uuid = Uuid::uuid4();
        return $uuid;
    }
    
    public static function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    public static function base64UrlDecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
    
    public function encode($uuid)
    {
        if (!self::isValidUuid($uuid)) {
            throw new RuntimeException("Invalid UUID");
        }
        $uuid = str_replace('-', '', $uuid);
        $bin = hex2bin($uuid);
        $xuid = self::base64UrlEncode($bin);
        return $xuid;
    }
    
    public function decode($xuid)
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
