<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use SETI_explorer\Crypto\Acme\Libraries\Encrypt;

$key = 'public.pem';
$data = ['lorem' => 'Ipsum', 'time' => time()];

$crypto = new Encrypt();
$crypto->setPassword(gen_random_string())
        ->setPublicKey($key) // remove this line to not encrypt data & iv (not recommended)
        ->process($data);

dd($crypto->output());
//dd($crypto->asJson());
//dd($crypto->asObject());