<?php 
class Hash{
	public static function make($string, $salt = ''){
		return hash('sha256', $string.$salt);
	}

	public static function salt($length){
		return random_bytes($length);
	}

	public static function unique(){
		return self::make(uniqid());
	}

    public static function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public static function randomString($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[self::crypto_rand_secure(0, $max)];
        }

        return $token;
    }

    public static function randomDigits($length){
        $digits ='';
        $numbers = range(0,99);
        shuffle($numbers);
        for($i = 0;$i < $length;$i++)
            $digits .= $numbers[$i];
        return $digits;
    }
}
?>