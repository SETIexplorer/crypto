<?php

namespace SETI_explorer\Crypto\Acme\Libraries\Traits;

trait CryptoTrait {

    /**
     * Clone of $results. Used for output
     * format manipulation.
     * 
     * @var array
     */
    protected $output;

    /**
     * Method used for encryption. List available here:
     * http://php.net/manual/en/function.openssl-get-cipher-methods.php
     * 
     * @var string
     */
    protected $method;

    /**
     * 
     * @param string $method
     * @return \SETI_explorer\Crypto\Encrypt
     */
    public function setMethod($method) {

        $this->method = $method;

        return $this;
    }

    /**
     * 
     * @return mixed
     */
    public function output() {
        return $this->output;
    }

    /**
     * 
     * @return string
     */
    public function asJson() {

        $this->output = json_encode($this->results);

        return $this->output();
    }

    /**
     * 
     * @return object
     */
    public function asObject() {

        $this->output = (object) $this->results;

        return $this->output();
    }

    /**
     * 
     * @param string $string
     * @return string
     */
    protected function publicEncrypt($string) {

        if ($this->public_key) {

            $encrypted = null;
            openssl_public_encrypt($string, $encrypted, $this->public_key);

            return $encrypted;
        }

        return false;
    }

    /**
     * 
     * @param string $string
     * @return string
     */
    protected function privateDecrypt($string) {

        if ($this->private_key) {

            $decypted = false;
            openssl_private_decrypt($string, $decypted, $this->private_key);

            return $decypted;
        }

        return $string;
    }

}
