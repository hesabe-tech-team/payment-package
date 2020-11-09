<?php

/**
 * Description of HesabeCrypt
 * This Encrypt Decrypt methods for API Request and Response over in Hesabe
 *
 * @author Hesabe
 */

namespace Hesabe\Payment;

class HesabeCrypt
{
    /**
     * AES Encryption Method
     * @param $str
     * @param $key
     * @param $ivKey
     * @return string
     */
    public static function encrypt($str, $key, $ivKey): string
    {
        $str = self::pkcs5Pad($str);
        $encrypted = openssl_encrypt($str, 'AES-256-CBC', $key, OPENSSL_ZERO_PADDING, $ivKey);
        $encrypted = base64_decode($encrypted);
        $encrypted = unpack('C*', $encrypted);
        $encrypted = self::byteArray2Hex($encrypted);
        return urlencode($encrypted);
    }

    /**
     * Decryption Method for AES Algorithm
     * @param $code
     * @param $key
     * @param $ivKey
     * @return false|string
     */
    public static function decrypt($code, $key, $ivKey)
    {
        if (!(ctype_xdigit($code) && strlen($code) % 2 === 0)) {
            return false;
        }
        $code = self::hex2ByteArray(trim($code));
        $code = self::byteArray2String($code);
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, 'AES-256-CBC', $key, OPENSSL_ZERO_PADDING, $ivKey);
        return self::pkcs5Unpad($decrypted);
    }

    private static function pkcs5Pad($text): string
    {
        $blockSize = 32;
        $pad = $blockSize - (strlen($text) % $blockSize);
        return $text . str_repeat(chr($pad), $pad);
    }

    private static function byteArray2Hex($byteArray): string
    {
        $chars = array_map("chr", $byteArray);
        $bin = implode($chars);
        return bin2hex($bin);
    }

    private static function hex2ByteArray($hexString)
    {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }

    private static function byteArray2String($byteArray): string
    {
        $chars = array_map("chr", $byteArray);
        return implode($chars);
    }

    private static function pkcs5Unpad($text)
    {
        $pad = ord($text[strlen($text) - 1]);
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) !== $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }
}
