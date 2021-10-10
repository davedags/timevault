<?php
//temporarily set this variable to what you are locking

$val = trim($argv[1]);
$lockUntil = $argv[2];

$key = file_get_contents('./master.key');

$encrypted = encryptWithTime($val, $key, $lockUntil);
$saveto = __DIR__ . '/encstore/encrypted-' . time();

file_put_contents($saveto, $encrypted);

echo 'Encrypted value saved to: ' . $saveto . "\n";

function encrypt($val, $key)
{
	
  // Store the cipher method
  $ciphering = "AES-128-CTR";
  
  // Use OpenSSl Encryption method
  $iv_length = openssl_cipher_iv_length($ciphering);
  
  // Non-NULL Initialization Vector for encryption
  $encryption_iv = getIV();

  // Use openssl_encrypt() function to encrypt the data
  $encrypted = openssl_encrypt($val, $ciphering, $key, 0, $encryption_iv);
  return $encrypted;
}

function encryptWithTime($val, $key, $datetime)
{    
  $valWithTime = strtotime($datetime) . '!:!' . $val;
  return encrypt($valWithTime, $key);
}


function getIV()
{
  return '1234567891011121';
}