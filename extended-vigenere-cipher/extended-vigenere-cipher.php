<?php

class ExtendedVigenere
{
  public static function encrypt($plainText, $key)
  {
    while (strlen($plainText) > strlen($key)) {
      $key .= $key;
    }
    while (strlen($plainText) < strlen($key)) {
      $key = substr($key, 0, strlen($key) - 1);
    }

    $plainTextArr = str_split($plainText);
    $keyArr = str_split($key);

    $plainValues = [];
    $keyValues = [];

    foreach ($plainTextArr as $plain) {
      $plainValues[] = ord($plain);
    }

    foreach ($keyArr as $keyItem) {
      $keyValues[] = ord($keyItem);
    }

    $cipherValues = [];

    for ($i = 0; $i < count($plainValues); $i++) {
      $cipherValues[] = ($plainValues[$i] + $keyValues[$i]) % 256;
    }


    // convert cypher values to cypher text
    $cipherText = '';
    foreach ($cipherValues as $value) {
      $cipherText .= chr($value);
    }

    return $cipherText;
  }

  public static function decrypt($cipherText, $key)
  {
    while (strlen($cipherText) > strlen($key)) {
      $key .= $key;
    }
    while (strlen($cipherText) < strlen($key)) {
      $key = substr($key, 0, strlen($key) - 1);
    }

    $cipherTextArr = str_split($cipherText);
    $keyArr = str_split($key);

    $cipherValues = [];
    $keyValues = [];

    foreach ($cipherTextArr as $cipher) {
      $cipherValues[] = ord($cipher);
    }

    foreach ($keyArr as $keyItem) {
      $keyValues[] = ord($keyItem);
    }

    $plainValues = [];

    for ($i = 0; $i < count($cipherValues); $i++) {
      $plainValue = ($cipherValues[$i] - $keyValues[$i]) % 256;
      $plainValues[] = $plainValue < 0 ? $plainValue += 256 : $plainValue;
    }

    // convert cypher values to cypher text
    $plainText = '';
    foreach ($plainValues as $value) {
      $plainText .= chr($value);
    }

    return $plainText;
  }
}
