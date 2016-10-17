<?php

require_once("Validation_Utility.php");
require_once("DB_Manager.php");
require_once("Error_Codes.php");
require_once("Status_Codes.php");
require_once("Validation_Manager.php");
require_once("recaptchalib.php");
require_once('API_Constants.php');

$sessionActive = ValidationUtility::sessionExists();

define("twitter_name_field", "twitter_name");
define("name_field", "name");
define("school_field", "school");
define("password_field", "password");
define("password_check_field", "password_check");
define('captcha_field', 'g-recaptcha-response');

$captcha_response = null;
$reCaptcha = new ReCaptcha(constant('recaptcha_secret'));

/*
echo $_POST[constant("twitter_name_field")];
echo $_POST[constant("name_field")];
echo $_POST[constant("school_field")];
echo $_POST[constant("password_field")];
*/

if( isset($_POST[constant("twitter_name_field")]) and 
	isset($_POST[constant("name_field")]) and
	isset($_POST[constant("school_field")]) and
	isset($_POST[constant("password_field")]) and
	isset($_POST[constant("password_check_field")]) and
	isset($_POST[constant('captcha_field')]) ){

	$captcha_value = $_POST[constant('captcha_field')];
	$captcha_response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $captcha_value);
	if( $captcha_response == null || !($captcha_response->success) ){
		ValidationUtility::setErrorCode("Recaptcha_Failure");
		header("location: View_Register.php");
		exit;
	}


	$twitter_name = $_POST[constant("twitter_name_field")];
	$name = $_POST[constant("name_field")];
	$school = $_POST[constant("school_field")];
	$password = $_POST[constant("password_field")];
	$password_check = $_POST[constant("password_check_field")];

	if( ValidationManager::validateFormRegisterUser($twitter_name, $name, $school, $password, $password_check) ){
		$db = new DBManager();

		$twitterID = ValidationManager::twitterNameToID($twitter_name);
		if( $twitterID == false ){
			header("location: View_Register.php");
			exit;
		}

		if( $db->addNewContestant($twitterID, $twitter_name, $name, $school, $password) ){
			ValidationUtility::setStatusCode("U_RegisterOK");
			header("location: index.php");	
			exit;
		} else {
			ValidationUtility::setErrorCode("DB_Failure");
			header("location: View_Register.php");
			exit;
		}
		unset($db);
	} else {
		header("location: View_Register.php");
		exit;
	}
	
} else {
	ValidationUtility::setErrorCode("U_missingInformation");
	header("location: View_Register.php");
	exit;
}

?>
