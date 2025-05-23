<?php
class EncryptionUtil {
    public static function encryptAES($data, $password) {
        $iv = openssl_random_pseudo_bytes(16);
        $key = hash('sha256', $password, true);
        $cipher = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $cipher);
    }

    public static function decryptAES($data, $password) {
        $data = base64_decode($data);
        $iv = substr($data, 0, 16);
        $cipher = substr($data, 16);
        $key = hash('sha256', $password, true);
        return openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }
}
