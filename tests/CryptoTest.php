<?php

use SETI_explorer\Crypto\Acme\Libraries\Encrypt;
use SETI_explorer\Crypto\Acme\Libraries\Decrypt;

class CryptoTest extends PHPUnit_Framework_TestCase {

    /**
     *
     * @var mixed
     */
    protected $data;

    /**
     * Private key pwd
     * 
     * @var string
     */
    protected static $password = 'test12345';

    /**
     *
     * @var SETI_explorer\Crypto\Acme\Libraries\Encrypt 
     */
    protected $encrypter;

    /**
     *
     * @var SETI_explorer\Crypto\Acme\Libraries\Decrypt 
     */
    protected $decrypter;

    public function setUp() {

        $this->data = 'Hello encrypted world!';

        $this->encrypter = (new Encrypt())->setPublicKey(__DIR__ . '/keys/public.pem');

        $this->decrypter = new Decrypt(__DIR__ . '/keys/private.pem', self::$password);
    }

    public function testEncryption() {

        $data = $this->encrypter
                ->setPassword(gen_random_string())
                ->process($this->data)
                ->asObject();

        $this->assertTrue(ctype_xdigit($data->iv), "IV is hexadecimal");
        $this->assertTrue(ctype_xdigit($data->data), "Data is hexadecimal");
        $this->assertTrue(ctype_xdigit($data->password), "Password is hexadecimal");
        
        return $data;
    }

    public function testDecryption() {
        $encrypted = $this->testEncryption();

        $data = $this->decrypter
                ->process($encrypted->data, $encrypted->password, $encrypted->iv)
                ->output(false);

        $this->assertTrue($data === $this->data, "Incorrect decrypted value.");
    }

}
