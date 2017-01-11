# Crypto
Created with simple encrypt/decrypt functionality & large data amounts in mind.

Key features:

1. Encrypts data using `openssl_encrypt()` with provided password.
2. Supports encryption/decryption of `password` and `initialization vector` with public/private key

# Encrypt data

```console
<?php

use SETI_explorer\Crypto\Acme\Libraries\Encrypt;

$key = __DIR__.'/keys/public.pem';
$data = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...';

$crypto = new Encrypt();
$crypto->setPassword(gen_random_string())
        ->setPublicKey($key)
        ->process($data);
```

* **Without initialization vector**

$crypto = new Encrypt(false);
$crypto->setPassword(gen_random_string())
        ->setPublicKey($key)
        ->process($data);

Using AES-192-OFB cipher

$crypto = new Encrypt(true, 'AES-192-OFB');
$crypto->setPassword(gen_random_string())
        ->setPublicKey($key)
        ->process($data);