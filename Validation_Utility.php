<?php
mb_internal_encoding('utf-8'); // FUNCIONA SIN ESTO, PERO RECOMENDARÍA USARLO.

require_once("TAE.php");
require_once("API_Constants.php");

define("HashAlgorithm", "md5");
define("PasswordMinLength", 6);
define("PasswordMaxLength", 20);
define("TwitterNameMaxLength", 15);
define("ContestantNameMaxLength", 40);
define("SchoolMaxLength", 50);

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
		/*
		return ctype_alnum($char) or $char == '_';
		*/
	}

	public static function isSpecialSpanishCharacter($char){
		return ($char == 'á' or $char == 'Á' or 
			$char == 'é' or $char == 'É' or
			$char == 'í' or $char == 'Í' or
			$char == 'ó' or $char == 'Ó' or
			$char == 'ú' or $char == 'Ú' or
			$char == 'ü' or $char == 'Ü' or
			$char == 'ñ' or $char == 'Ñ');
	}

	public static function isAplhaOrSpace($char){
		return (ctype_alpha($char) or $char == ' ' or ValidationUtility::isSpecialSpanishCharacter($char));
	}

	public static function isAlphaAndSpacesString(&$string){
		/*$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
		$string = strtr( $string, $unwanted_array );*/

		$string_length = mb_strlen($string); // USANDO CADENAS MULTIBYTE NECESITAS USAR FUNCIONES mb_*
		for($i = 0; $i < $string_length; $i++){
			if( !ValidationUtility::isAplhaOrSpace(mb_substr($string, $i, 1)) ){ // ANTES ESTABA COMO $string[$i] ESO NO FUNCIONA CON
																				 // CADENAS MULTIBYTE, SE NECESITA mb_substr, QUE USO
																				 // SIMPLEMENTE PARA OBTENER EL i-ÉSIMO CHAR.
				return false;
			}
		}
		return true;
	}

	public static function isValidName($name){
		return ValidationUtility::isAlphaAndSpacesString($name);
	}

	public static function isValidSchool($school){
		return ValidationUtility::isAlphaAndSpacesString($school);
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

	public static function passwordsMatch($password1, $password2){
		return $password1 == $password2;
	}

	public static function isValidPasswordLength($password){
		return (ValidationUtility::stringLengthIsAtLeast($password, 6) and 
			ValidationUtility::stringLengthIsAtMost($password, 20));
	}

	public static function isValidNameLength($name){
		return ValidationUtility::stringLengthIsAtMost($name, constant("ContestantNameMaxLength"));
	}

	public static function isValidSchoolLength($school){
		return ValidationUtility::stringLengthIsAtMost($school, constant("SchoolMaxLength"));
	}

	public static function isValidTwitterNameLength($twitter_name){
		return ValidationUtility::stringLengthIsAtMost($twitter_name, constant("TwitterNameMaxLength"));
	}

	public static function stringIsEmpty($string){
		return (strlen($string) == 0);
	}

	public static function arrayIsEmpty($array){
		return (count($array) == 0);
	}

	public static function stringLengthIsAtMost($string, $max_length){
		return (strlen($string) <= $max_length);
	}

	public static function stringLengthIsAtLeast($string, $min_length){
		return (strlen($string) >= $min_length);
	}

	public static function sessionExists(){
		session_start();
		return isset($_SESSION["id"]);
	}

	public static function getErrorCode(){
		session_start();
		if(isset($_SESSION["errorCode"])){
			$errorCode = $_SESSION["errorCode"];
			unset($_SESSION["errorCode"]);
			return $errorCode;
		}
		return "";
	}

	public static function setErrorCode($errorCode){
		session_start();
		$_SESSION["errorCode"] = $errorCode;
	}

	public static function getStatusCode(){
		session_start();
		if(isset($_SESSION["statusCode"])){
			$statusCode = $_SESSION["statusCode"];
			unset($_SESSION["statusCode"]);
			return $statusCode;
		}
		return "";
	}

	public static function setStatusCode($statusCode){
		session_start();
		$_SESSION["statusCode"] = $statusCode;
	}

	public static function twitterNameExists($twitter_name){
		$settings = array(
					'oauth_access_token' => constant('twitter_oauth_access_token'),
					'oauth_access_token_secret' => constant('twitter_oauth_access_token_secret'),
					'consumer_key' => constant('twitter_consumer_key'),
					'consumer_secret' => constant('twitter_consumer_secret')
					);
		$url = 'https://api.twitter.com/1.1/users/lookup.json';
		$requestMethod = 'GET';	
		$twitter = new TwitterAPIExchange($settings);
		$getfield = '?screen_name=' . $twitter_name;
		$string = json_decode($twitter->setGetfield($getfield)
			->buildOauth($url, $requestMethod)
			->performRequest(),$assoc = TRUE);
		//print_r($string);
		$user = $string[0];
		if( isset($user['id_str']) ){
			return $user['id_str'];
		}
		return false;
	}


}	
?>