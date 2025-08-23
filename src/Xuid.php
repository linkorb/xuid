<?php

namespace Xuid;

use Ramsey\Uuid\Uuid;
use RuntimeException;

/**
 * XUID (eXtended Unique IDentifier) utility class
 * 
 * Provides functionality to generate and manipulate XUIDs, which are 
 * URL-safe, base64-encoded representations of UUIDs.
 */
class Xuid
{
    /**
     * @var array<string, string> Character mapping for base64 URL encoding
     */
    protected static array $map = [
        '+' => '-',
        '/' => '_',
    ];

    /**
     * @var bool Whether to force alphanumeric-only XUIDs
     */
    protected static bool $alphaNumericOnly = false;

    /**
     * Force generation of alphanumeric-only XUIDs
     * 
     * @param bool $force Whether to force alphanumeric-only generation
     */
    public static function forceAlphaNumeric(bool $force = true): void
    {
        self::$alphaNumericOnly = $force;
    }

    /**
     * Set custom character mapping for base64 URL encoding
     * 
     * @param array<string, string> $map Character mapping array
     */
    public static function setMap(array $map): void
    {
        self::$map = $map;
    }

    /**
     * Validate if a string is a valid UUID
     * 
     * @param string $uuid The UUID string to validate
     * @return bool True if valid UUID, false otherwise
     */
    public static function isValidUuid(string $uuid): bool
    {
        if (preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $uuid)) {
            return true;
        }
        return false;
    }
    
    /**
     * Validate if a string is a valid XUID
     * 
     * @param string $xuid The XUID string to validate
     * @return bool True if valid XUID, false otherwise
     */
    public static function isValidXuid(string $xuid): bool
    {
        $uuid = self::decode($xuid);
        return self::isValidUuid($uuid);
    }
    
    
    /**
     * Generate a new XUID
     * 
     * @return string A new XUID string
     */
    public static function getXuid(): string
    {
        do {
            $uuid = self::getUuid();
            $xuid = self::encode($uuid);
        } while (self::$alphaNumericOnly && !ctype_alnum($xuid));
        return $xuid;
    }
    
    /**
     * Generate a new UUID v4
     * 
     * @return string A new UUID v4 string
     */
    public static function getUuid(): string
    {
        $uuid = Uuid::uuid4();
        return $uuid->toString();
    }
    
    /**
     * Encode data using base64 URL-safe encoding
     * 
     * @param string $data The data to encode
     * @return string The base64 URL-safe encoded string
     */
    public static function base64UrlEncode(string $data): string
    {
        $str = rtrim(base64_encode($data), '=');
        foreach (self::$map as $from => $to) {
            $str = str_replace($from, $to, $str);
        }
        return $str;
    }
    
    /**
     * Decode base64 URL-safe encoded data
     * 
     * @param string $data The base64 URL-safe encoded string to decode
     * @return string The decoded data
     */
    public static function base64UrlDecode(string $data): string
    {
        $str = strtr($data, '-_', '+/');
        foreach (self::$map as $from => $to) {
            $str = str_replace($to, $from, $str);
        }
        $str = base64_decode(str_pad($str, strlen($str) % 4, '=', STR_PAD_RIGHT));
       
        return $str;
    }
    
    /**
     * Encode a UUID to XUID format
     * 
     * @param string $uuid The UUID string to encode
     * @return string The encoded XUID string
     * @throws RuntimeException If the UUID is invalid
     */
    public static function encode(string $uuid): string
    {
        if (!self::isValidUuid($uuid)) {
            throw new RuntimeException("Invalid UUID");
        }
        $uuid = str_replace('-', '', $uuid);
        $bin = hex2bin($uuid);
        $xuid = self::base64UrlEncode($bin);
        return $xuid;
    }
    
    /**
     * Decode a XUID to UUID format
     * 
     * @param string $xuid The XUID string to decode
     * @return string The decoded UUID string
     * @throws RuntimeException If the XUID is invalid
     */
    public static function decode(string $xuid): string
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
