<?php

require_once("Validation_Utility.php");
require_once("DB_Manager.php");

if( isset($_POST["twitter_name"]) and isset($_POST["password"]) ){
	$loginSucceeded = false;

	$twitter_name = ValidationUtility::sanitizeString($_POST["twitter_name"]);
	$password = ValidationUtility::sanitizeString($_POST["password"]);

	if( ValidationUtility::isValidTwitterName($twitter_name) 
		and ValidationUtility::isValidPassword($password) ){

		$password = ValidationUtility::hashString($password);
		$db = new DBManager();
		$contestantInformation = $db->getContestantInformationFromLogin($twitter_name, $password);

		//print_r($contestantInformation);

		$loginSucceeded = !(ValidationUtility::arrayIsEmpty($contestantInformation));

		if($loginSucceeded){
			session_start();
			$_SESSION["id"] = $contestantInformation["id"];
			$_SESSION["twitter_name"] = $contestantInformation["twitter_name"];
			//echo $_SESSION["id"];
			//echo $_SESSION["twitter_name"];
			header("location: index.php");
		}else {
			header("location: View_Login.php");
		}
	} else {
		header("location: View_Login.php");
	}
}

?>