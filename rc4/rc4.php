<?php

class RC4
{
  private $larik;
  public $key = '';
  public $text = '';
  public $output = '';
  public $method = '';

  public function __construct($text, $key, $method)
  {
    $this->larik = range(0, 255);
    $this->key = $key;
    $this->method = $method;
    if ($method === 'encrypt') {
      $this->text = ExtendedVigenere::encrypt($text, $key);
    } else if ($method === 'decrypt') {
      $this->text = $text;
    }
  }

  private function swapLarikElement($i, $j)
  {
    $temp = $this->larik[$i];
    $this->larik[$i] = $this->larik[$j];
    $this->larik[$j] = $temp;
  }

  private function ksa()
  {
    $j = 0;
    for ($i = 0; $i <= 255; $i++) {
      $j = ($j + $this->larik[$i] +  $this->convertToByte($this->key[$i % strlen($this->key)])) % 256;
      $this->swapLarikElement($i, $j);
    }
  }

  private function prga()
  {
    $i = 0;
    $j = 0;
    for ($k = 0; $k < strlen($this->text); $k++) {
      $i = ($i + 1) % 256;
      $j = ($j + $this->larik[$i]) % 256;
      $this->swapLarikElement($i, $j);
      $t = ($this->larik[$i] + $this->larik[$j]) % 256;
      $this->processCipher($t, $k);
    }
  }

  private function processCipher($t, $k)
  {
    $u = $this->larik[$t];
    $p = $this->convertToByte($this->text[$k]);
    $this->output .= $this->convertToChar($u ^ $p);
  }

  private function convertToByte($char)
  {
    return unpack('C*', $char)[1];
  }

  private function convertToChar($byte)
  {
    return pack('C*', $byte);
  }

  public function doCipher()
  {
    $this->ksa();
    $this->prga();
    if ($this->method === 'decrypt') {
      $this->output = ExtendedVigenere::decrypt($this->output, $this->key);
    }
  }
}

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

// // testing
// $test = new RC4('Selamat sore gaess', 'Terbanglah sampai ke angkasa setinggi bintang di langit');
// $test->doCipher();
// var_dump($test->output);
