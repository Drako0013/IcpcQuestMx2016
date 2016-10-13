<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("Validation_Utility.php");
require_once("DB_Manager.php");
require_once("Error_Codes.php");
require_once("Status_Codes.php");

$sessionActive = ValidationUtility::sessionExists();

define("twitter_name_field", "twitter_name");
define("name_field", "name");
define("school_field", "school");
define("password_field", "password");
define("password_check_field", "password_check");

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
	isset($_POST[constant("password_check_field")]) ){

	$twitter_name = ValidationUtility::sanitizeString($_POST[constant("twitter_name_field")]);
	$name = ValidationUtility::sanitizeString(utf8_decode($_POST[constant("name_field")]));
	$school = ValidationUtility::sanitizeString(utf8_decode($_POST[constant("school_field")]));
	$password = ValidationUtility::sanitizeString($_POST[constant("password_field")]);
	$password_check = ValidationUtility::sanitizeString($_POST[constant("password_check_field")]);

	if( !ValidationUtility::isValidTwitterName($twitter_name) ){
		ValidationUtility::setErrorCode("U_twitterName");
		header("location: View_Register.php");
		exit;
	}

	if( !ValidationUtility::isValidTwitterNameLength($twitter_name) ){
		ValidationUtility::setErrorCode("U_twitterNameLength");
		header("location: View_Register.php");
		exit;
	}

	if( !ValidationUtility::isValidName($name) ){
		ValidationUtility::setErrorCode("U_name");
		header("location: View_Register.php");
		exit;
	}

	if( !ValidationUtility::isValidNameLength($name) ){
		ValidationUtility::setErrorCode("U_nameLength");
		header("location: View_Register.php");
		exit;
	}

	if( !ValidationUtility::isValidSchool($school) ){
		ValidationUtility::setErrorCode("U_school");
		header("location: View_Register.php");
		exit;
	}

	if( !ValidationUtility::isValidSchoolLength($school) ){
		ValidationUtility::setErrorCode("U_schoolLength");
		header("location: View_Register.php");
		exit;
	}

	if( !ValidationUtility::isValidPasswordLength($password) ){
		ValidationUtility::setErrorCode("U_passwordLength");
		header("location: View_Register.php");
		exit;
	}

	if( !ValidationUtility::passwordsMatch($password, $password_check) ){
		ValidationUtility::setErrorCode("U_passwordNotMatch");
		header("location: View_Register.php");
		exit;
	}
	
	$password = ValidationUtility::hashString($password);
	$db = new DBManager();
	$db->addNewContestant($twitter_name, $name, $school, $password);
	ValidationUtility::setStatusCode("U_RegisterOK");
	header("location: index.php");	
	exit;

} else {
	ValidationUtility::setErrorCode("U_missingInformation");
	header("location: View_Register.php");
	exit;
}

?>
