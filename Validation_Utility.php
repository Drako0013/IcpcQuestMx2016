<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

define("HashAlgorithm", "md5");

class ValidationUtility{
	
	public static function hashString($string){
		return hash(constant("HashAlgorithm"), $string);
	}

	public static function sanitizeString($string){
		$string = strip_tags($string);
		$string = htmlspecialchars($string);
		$string = trim(rtrim(ltrim($string)));
		return $string;
	}

	public static function isValidCharacterTwitterName($char){
		return ($char >= 'A' and $char <= 'Z') or
			($char >= 'a' and $char <= 'z') or 
			($char >= '0' and $char <= '9') or
			$char == '_';
		//return ctype_alnum($char) or $char == '_';
	}

	public static function isValidTwitterName($twitter_name){
		$name_length = strlen($twitter_name);
		$isValid = ($name_length >= 1 and $name_length <= 15);
		if($isValid){
			for($i = 0; $i < $name_length; $i++){
				if( !ValidationUtility::isValidCharacterTwitterName($twitter_name[$i]) ){
					return false;
				}
			}
			return true;
		} else {
			return false;
		}
	}

	public static function isValidPassword($password){
		return (strlen($password) >= 6 and strlen($password) <= 20);
	}
}	
?>