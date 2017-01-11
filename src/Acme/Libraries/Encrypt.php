<?php

namespace SETI_explorer\Crypto\Acme\Libraries;

use RuntimeException;

class Encrypt {

    use Traits\CryptoTrait;

    /**
     * Cipher initialization vector
     * 
     * @var string
     */
    protected $iv;

    /**
     * Used with openssl_encrypt()
     * 
     * @var string
     */
    protected $password;

    /**
     * Used to encrypt password.
     * 
     * @var resource
     */
    protected $public_key;

    /**
     *
     * @var array
     */
    protected $results = [
        'iv' => null,
        'data' => null,
        'password' => null
    ];

    /**
     * 
     * @param string $method
     */
    public function __construct($iv = true, $method = 'aes-256-ctr') {

        $this->setMethod($method);

        if ($iv && function_exists('mcrypt_create_iv')) {

            if (is_bool($iv)) {
                $iv = mcrypt_create_iv(openssl_cipher_iv_length($method));
            }

            $this->setIv($iv);
        }
    }

    /**
     * 
     * @param mixed $data
     * @return \SETI_explorer\Crypto\Acme\Libraries\Encrypt
     */
    public function process($data) {

        if (is_array($data) || is_object($data)) {
            $data = serialize($data);
        }

        if (!$encrypted = openssl_encrypt($data, $this->method, $this->password, true, $this->iv)) {
            throw new RuntimeException("Failed to encrypt data.");
        }

        $this->results = $this->output = array_combine(array_keys($this->results), [
            bin2hex($this->getIv()), // iv
            bin2hex($encrypted), // data (hex)
            bin2hex($this->getPassword()), // password (hex)
        ]);

        return $this;
    }

    /**
     * 
     * @param string $filename
     * @return \SETI_explorer\Crypto\Encrypt
     * @throws RuntimeException
     */
    public function setPublicKey($filename) {

        if (!file_exists($filename)) {
            throw new RuntimeException("Public key file $filename not found.");
        } else if (!$this->public_key = openssl_get_publickey(file_get_contents($filename))) {
            throw new RuntimeException("Error opening public key file $filename.");
        }

        return $this;
    }

    /**
     * 
     * @param string $password
     * @return \SETI_explorer\Crypto\Encrypt
     */
    public function setPassword($password) {

        $this->password = $password;

        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getPassword() {

        if (!$password = $this->publicEncrypt($this->password)) {

            trigger_error("No public key, password is NOT encrypted!!!", E_USER_WARNING);
            return $this->password;
        }

        return $password;
    }

    /**
     * 
     * @param string $iv
     * @return \SETI_explorer\Crypto\Encrypt
     * @throws RuntimeException
     */
    public function setIv($iv) {

        $length = openssl_cipher_iv_length($this->method);

        if (mb_strlen($iv, 'utf8') > $length) {
            throw new RuntimeException("Max iv length for $this->method is $length.");
        }

        $this->iv = $iv;

        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getIv() {

        if (!$this->iv) {
            return false;
        } else if (!$iv = $this->publicEncrypt($this->iv)) {

            trigger_error("No public key, init vector is NOT encrypted!!!", E_USER_WARNING);
            return $this->iv;
        }

        return $iv;
    }

}
