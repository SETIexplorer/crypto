<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use SETI_explorer\Crypto\Acme\Libraries\Decrypt;

$key_pwd = 'password';
$key_file = 'private.pem';

$iv = '';
$data = '';
$password = '';

$crypto = new Decrypt($key_file, $key_pwd);
$crypto->process($data, $password, $iv);

dd($crypto->output());