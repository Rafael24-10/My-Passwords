<?php

namespace App\Controller;

class EncryptionController
{
    /**
     * Hash a password using bcrypt algorithm.
     * @param string $password The password to be hashed.
     * @return string The hashed password.
     */

    protected function hashPassword(string $password): string
    {
        $options = [
            'cost' => 12
        ];

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    /**
     * Encrypts a string using AES-256-CBC algorithm.
     * @param string $data The data to encrypt.
     * @param string $key The encryption key.
     * @return string The encrypted data.
     */

    protected function encryptWithOpenSSL(string $data, string $key): string
    {
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        return base64_encode($iv . $encrypted);
    }

    /**
     * decrypts a string encrypted with AES-256-CBC algorithm.
     *@param string $data The data to be decrypted .
     *@param string $key The encryption key.
     *@return string The decrypted data.
     */

    protected function decryptOpenSSL(string $data, string $key): string
    {
        $string = base64_decode($data);
        $iv = substr($string, 0, 16);
        $encryptedString = substr($string, 16);
        return openssl_decrypt($encryptedString, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }
}
