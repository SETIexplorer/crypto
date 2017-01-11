# Crypto
Created with simple encrypt/decrypt functionality & large data amounts in mind.

Key features:

1. Encrypts data using `openssl_encrypt()` with provided password.
2. Supports encryption/decryption of `password` and `initialization vector` with public/private key

# Encrypt data

$key = __DIR__.'/keys/public.pem';
$data = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

1.

$crypto = new Encrypt();
$crypto->setPassword(gen_random_string())
        ->setPublicKey($key)
        ->process($data);

2. (without initialization vector)

$crypto = new Encrypt(false);
$crypto->setPassword(gen_random_string())
        ->setPublicKey($key)
        ->process($data);

3. (using AES-192-OFB cipher)

$crypto = new Encrypt(true, 'AES-192-OFB');
$crypto->setPassword(gen_random_string())
        ->setPublicKey($key)
        ->process($data);