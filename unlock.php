<?php

$file = $argv[1];

if (($key = @file_get_contents('./master.key')) === false) {
   echo 'No master.key found';
   exit;
}

$encrypted = file_get_contents($file);
if ($decrypted = decryptWithTime($encrypted, $key)) {
  echo "Decryption Successful:\n\n${decrypted}\n";
} else {
  echo "Could not decrypt\n";
}


function decrypt($encrypted, $key)
{
  // Store the cipher method
  $ciphering = "AES-128-CTR";
  
  // Use OpenSSl Encryption method
  $iv_length = openssl_cipher_iv_length($ciphering);

  // Non-NULL Initialization Vector for decryption
  $decryption_iv = getIV();

  // Use openssl_decrypt() function to decrypt the data
  $decrypted = openssl_decrypt ($encrypted, $ciphering, $key, 0, $decryption_iv);
  return $decrypted;
}

function decryptWithTime($encrypted, $key)
{
   $decrypted = decrypt($encrypted, $key);
   $components = explode('!:!', $decrypted);
   $now = time();
   if (is_array($components) && count($components) == 2) {
       if ($now >= $components[0]) {
           return $components[1];
       } else {
       	  $minutes_left = ceil(($components[0] - $now) / 60);
	  echo "Vault is locked! - ${minutes_left} minutes until vault can be opened\n\n";
       }
   }
   return false;
}

function getIV()
{
  return '1234567891011121';
}