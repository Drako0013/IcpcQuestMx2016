<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("Validation_Utility.php");
require_once("DB_Manager.php");

define("twitter_name_field", "twitter_name");
define("name_field", "name");
define("school_field", "school");
define("password_field", "password");

/*
echo $_POST[constant("twitter_name_field")];
echo $_POST[constant("name_field")];
echo $_POST[constant("school_field")];
echo $_POST[constant("password_field")];
*/

if( isset($_POST[constant("twitter_name_field")]) and 
	isset($_POST[constant("name_field")]) and
	isset($_POST[constant("school_field")]) and
	isset($_POST[constant("password_field")]) ){
	$statusOK = true;

	$twitter_name = ValidationUtility::sanitizeString($_POST[constant("twitter_name_field")]);
	$name = ValidationUtility::sanitizeString($_POST[constant("name_field")]);
	$school = ValidationUtility::sanitizeString($_POST[constant("school_field")]);
	$password = ValidationUtility::sanitizeString($_POST[constant("password_field")]);

	$statusOK = ValidationUtility::isValidTwitterName($twitter_name) and 
		ValidationUtility::isValidPassword($password);
	$password = ValidationUtility::hashString($password);
	if($statusOK){
		$db = new DBManager();
		$db->addNewContestant($twitter_name, $name, $school, $password);
		header("location: index.php");	
	} else {
		header("location: View_Register.php");
	}
} else {
	header("location: View_Register.php");
}

?>
