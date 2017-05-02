<?php

class enc{
	public $secretkey;
	public $secretiv;
	public $encryptMethod = "AES-256-CBC";

	public function __construct($key,$password)
  	{
     	$this->secretkey = $key;
     	$this->secretiv = $password;
  	}

	public function encrypt($data){
		$key = hash("sha256",$this->secretkey);
		$iv = substr(hash("sha256",$this->secretiv), 0, 16);
		$result = openssl_encrypt($data,$this->encryptMethod,$key,0,$iv);
		return $result = base64_encode($result);
	}

	public function decrypt($data){
		$key = hash("sha256",$this->secretkey);
		$iv = substr(hash("sha256",$this->secretiv), 0, 16);
		$result = openssl_decrypt(base64_decode($data),$this->encryptMethod,$key,0,$iv);
		return $result;
	}
}

// $en = new enc("ebe@gmail.com","ilemobayo");
// $user = $en->encrypt("Ayejuni Ilemobayo");
// echo "{$user}";
// $user = $en->decrypt("{$user}");
// echo "{$user}";
// $en = new enc("ebe@gmail.com","ilemobayo");
// $user = $en->decrypt("QzdBaXpDbWg3Zlc3WTZKUDA4dEk1Z1pmd0JxWlZJeFJua29jTi9lY09XYz0=");
// echo "<div>{$user}</div>";
?>