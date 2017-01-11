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

dd($crypto->output()); // dumps results array
//dd($crypto->asJson());
//dd($crypto->asObject());
```

* **Without initialization vector**

```console
$crypto = new Encrypt(false);
$crypto->setPassword(gen_random_string())
        ->setPublicKey($key)
        ->process($data);
```
* **Using AES-192-OFB cipher**

```console
$crypto = new Encrypt(true, 'AES-192-OFB');
$crypto->setPassword(gen_random_string())
        ->setPublicKey($key)
        ->process($data);
```

# Decrypt data

```console
<?php

use SETI_explorer\Crypto\Acme\Libraries\Decrypt;

$key_pwd = 'password';
$key_file = 'private.pem';

$iv = '03529dcb4337bb42d776c1dd9d908ad70778116344f3e38dedd2bf0cabee4179b6d0dfeb5924da1dbf69b1bb3aa445e8c4befdbc427da29d11febfa815dfda576c8ee0af073cd2bea0e5c3c0ac1d63e7899fdeaa65c7df42093543511eda2ebf5b625daeb5d3be1322b074fe843b85f9a8a6bc606fa8d46a4175898143082936e12046bec93aaf56fb91c6b62da9bf9fa9f2caf061751d5d20618eddeeb7cad90aa78e277de0e651c194522d8e1c862e42e62b362580bf750dfec29a8672610019488078abfc87d969d0d8d978bfa7830afd48616f7ff4a5845adad4e085a914baa80755a1dca7533224e83c67af33f9b9f2f03fe1d37fc482e387f811228a554cb4b63d22456c186c18cc969d1673e5f65b007a61c0611441c09f46cba4e2071e409a6d0a356c3a51b0913223fe6409f4593a8bdee9426e85c1ee854425b8d697655ab003fdc5c261bcff57cb90f2f9ef043bcc7c69302a1ca9635c0b794f1926f86350aa1a97cd6f30579eb0fdc47e1f6b9f975a59ecebd956bf767d50dbdfbc339eea9d5c3b5368707dace9ecaee39546188b1a15231c5f70d3a0073dc89d74fac56e4c6d7e508d43d4bc4ec7239c29ec3466cdac4dbd8e12bd36ff9dc44e8089114e4231258dc1cb0a4f4b200a9935db823c8dc0b79151e2a12e41424040c26e0a762f355e3e8b88b6438a5c7bc09defa697efebdee36a83f7f05e';
$data = '2df9def0ad040ea0c1546abc8e3d3c0f8574a21801fda26a71aa369709f016dd1f64ce7c4df2faa15edfae28eb85fc3adccf39895616';
$password = '08144d1ce87387675e93b338a22791c57ec4cc17901335980f7699bbb8289f5dce2ea57ba1f31f2ebe9234cab7ed8acba2f1a8ab2984aca2536281083aa453847c042307fd23fa01f1552e1a18390472797ec4a670defed5e9b58b66da662384d5165507ccc1fac95ea12a6eee8663897476e84d7ff350b3612b3cb12d721f1f509914f45fd59cbb97acd0239f08644ae52d4f20f4a864f85bc9d3ad4b47a9e7bd87e912943f28748c659dd2d8fe2459e10c926d2e8575609e2d3de173e53cb27208df2dbc608589a72adcd3f0888a2ced1089e9258d7dd7491e1c9b28ed975da609a29e1a9480acbfce6e2435a7eb596b051494e19b664e88a8c7f05adee5db641459f16d656a88be8dac20c80b408b935b5e955d4e9ab785e3b5c77953cf1aabfa954c42d4414b2dfc2a1340041354ed71570cbc4a3d6facb1f8f0047927b4b575ffbce7d1402ff45ae0f8bfd03fce7c624679e68b3c5cde008c3529c0785bd1600c6cc2c0e772aac4b4b4f947467ba86be910c4af89a0f924e4ebc80fefddde4bd0a5b94f9bdb9de607c7b437c9d6b5ead9b7b86623d9d0c14ad5e8d67b5786c1465ed95a56aa2eaaea82f19ed89c3ba367a90c2fb1f51528e059ea04e68e328b5359b66a3bc7b61eef9deb83965f8a6b6fe835bff192b63ee2b4cc202d7b9dc20a1bf17d769f4d57818d2be25e9f62b469555623338ca0c99377e7';

$crypto = new Decrypt($key_file, $key_pwd);
$crypto->process($data, $password, $iv);

dd($crypto->output());
```