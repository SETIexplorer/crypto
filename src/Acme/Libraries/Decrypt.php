<?php

namespace SETI_explorer\Crypto\Acme\Libraries;

use RuntimeException;

class Decrypt {

    use Traits\CryptoTrait;

    /**
     *
     * @var string
     */
    protected $results;

    /**
     *
     * @var string
     */
    protected $private_key;

    /**
     * 
     * @param string|false $key
     * @param string|false $password
     * @param string $method
     */
    public function __construct($key = false, $password = false, $method = 'aes-256-ctr') {

        $this->setMethod($method);

        if ($key || $password) {
            $this->loadPrivateKey($key, $password);
        }
    }

    /**
     * 
     * @param string $data
     * @param string $password
     * @param string|false $iv
     * @return \SETI_explorer\Crypto\Acme\Libraries\Decrypt
     * @throws RuntimeException
     */
    public function process($data, $password, $iv = false) {

        $options = [
            ctype_xdigit($data) ? hex2bin($data) : $data, // data
            $this->method, // method
            $this->privateDecrypt(ctype_xdigit($password) ? hex2bin($password) : $password) // pwd
        ];

        if ($iv) {

            $options = array_merge($options, [
                true,
                $this->privateDecrypt(ctype_xdigit($iv) ? hex2bin($iv) : $iv)
            ]);
        }

        if (!$this->output = $this->results = call_user_func_array('openssl_decrypt', $options)) {
            throw new RuntimeException("Failed to decrypt data.");
        }

        return $this;
    }

    /**
     * 
     * @param string $filename
     * @param string|false $password
     * @return \SETI_explorer\Crypto\Acme\Libraries\Decrypt
     * @throws RuntimeException
     */
    public function loadPrivateKey($filename, $password = false) {

        if (!file_exists($filename)) {
            throw new RuntimeException("Private key file $filename not found.");
        } else if (!$this->private_key = openssl_get_privatekey(file_get_contents($filename), $password)) {
            throw new RuntimeException("Error opening private key file $filename.");
        }

        return $this;
    }

    /**
     * 
     * @param boolean $unserialize
     * @return string
     */
    public function output($unserialize = true) {

        $output = unserialize($this->output);
        if ($unserialize && $output !== false) {
            return $output;
        }

        return $this->output;
    }

}
