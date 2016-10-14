<?php

require_once("Validation_Utility.php");
require_once("DB_Manager.php");
require_once("Error_Codes.php");
require_once("Status_Codes.php");
require_once("Validation_Manager.php");

if( isset($_POST["twitter_name"]) and isset($_POST["password"]) ){
	$twitter_name = $_POST["twitter_name"];
	$password = $_POST["password"];

	if( !ValidationManager::validateFormLogin($twitter_name, $password) ){
		header("location: View_Login.php");
		exit;
	}

	$db = new DBManager();
	$contestantInformation = $db->getContestantInformationFromLogin($twitter_name, $password);
	unset($db);
	//print_r($contestantInformation);
	//print_r($contestantInformation);
	if( ValidationUtility::arrayIsEmpty($contestantInformation) ){
		ValidationUtility::setErrorCode("U_loginFailure");
		header("location: View_Login.php");
		exit;
	}

	if( $contestantInformation == false ){
		ValidationUtility::setErrorCode("DB_Failure");
		header("location: View_Login.php");
		exit;
	}

	session_start();
	$_SESSION["id"] = $contestantInformation["id"];
	$_SESSION["twitter_name"] = $contestantInformation["twitter_name"];
	ValidationUtility::setStatusCode("U_LoginOK");
	header("location: index.php");
	exit;
} else {
	ValidationUtility::setErrorCode("U_missingInformation");
	header("location: View_Login.php");
	exit;
}

?>