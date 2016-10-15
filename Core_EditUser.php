<?php
require_once("DB_Manager.php");
require_once("Validation_Utility.php");
require_once("Validation_Manager.php");

$sessionActive = ValidationUtility::sessionExists();

if( $sessionActive ){
	$id = (int)$_SESSION["id"];
	if( isset($_POST["twitter_name"]) and 
		isset($_POST["name"]) and 
		isset($_POST["school"]) and 
		isset($_POST["password"]) ){

		$twitter_name = $_POST["twitter_name"];
		$name = $_POST["name"];
		$school = $_POST["school"];
		$password = $_POST["password"];
		$new_password = $_POST["new_password"];
		$new_password_check = $_POST["new_password_check"];

		$passwordChange = !(empty($new_password));

		if( !ValidationManager::validateFormEditUser($twitter_name, $name, $school, $password, $new_password, $new_password_check) ){
			header("location: View_EditUser.php");
			exit;
		}
		$db = new DBManager();
		$savedPassword = $db->getContestantPassword($id);
		if( $password != $savedPassword ){
			unset($db);
			ValidationUtility::setErrorCode("U_savedPasswordNotMatch");
			header("location: View_EditUser.php");
			exit;
		}

		$twitter_id = ValidationManager::twitterNameToID($twitter_name);
		if( $twitter_id == false ){
			header("location: View_EditUser.php");
			exit;
		}

		if($passwordChange){
			if( !$db->editContestantInformation($id, $twitter_id, $twitter_name, $name, $school, $new_password) ){
				ValidationUtility::setErrorCode("DB_Failure");
				header("location: View_EditUser.php");
				exit;
			}
		} else {
			if( !$db->editContestantInformationWoPassword($id, $twitter_id, $twitter_name, $name, $school)){
				ValidationUtility::setErrorCode("DB_Failure");
				header("location: View_EditUser.php");
				exit;
			}
			
		}
		unset($db);
		ValidationUtility::setStatusCode("U_EditOK");
		$_SESSION["twitter_name"] = $twitter_name;
		header("location: index.php");
		exit;
	}
} else {
	ValidationUtility::setErrorCode("U_missingInformation");
	header("location: View_EditUser.php");
	exit;
}

?>