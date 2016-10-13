<?php
require_once("DB_Manager.php");
require_once("Validation_Utility.php");

$sessionActive = ValidationUtility::sessionExists();
if( $sessionActive ){
	$id = $_SESSION["id"];
	if( isset($_POST["twitter_name"]) and isset($_POST["name"]) and isset($_POST["school"]) and isset($_POST["password"]) ){
		$twitter_name = ValidationUtility::sanitizeString($_POST["twitter_name"]);
		$name = ValidationUtility::sanitizeString($_POST["name"]);
		$school = ValidationUtility::sanitizeString($_POST["school"]);
		$password = ValidationUtility::sanitizeString($_POST["password"]);
		$password = ValidationUtility::hashString($password);

		$db = new DBManager();
		$savedPassword = $db->getContestantPassword($id);
		if( $password == $savedPassword ){
			if( empty($_POST["new_password"]) ){
				$db->editContestantInformationWoPassword($id, $twitter_name, $name, $school);
				$_SESSION["twitter_name"] = $twitter_name;
				header("location: index.php");
			} else {
				if(!empty($_POST["new_password_check"])){
					if( $_POST["new_password"] == $_POST["new_password_check"] ){
						$new_password = ValidationUtility::sanitizeString($_POST["new_password"]);
						$new_password = ValidationUtility::hashString($new_password);
						$db->editContestantInformation($id, $twitter_name, $name, $school, $new_password);
						$_SESSION["twitter_name"] = $twitter_name;
						header("location: index.php");
					} else {
						header("location: View_EditUser.php");
					}
				} else {
					header("location: View_EditUser.php");
				}
			}
		} else {
			ValidationUtility::setErrorCode("U_missingInformation");
			header("location: View_EditUser.php");
			exit;
		}
	}
} else {
	header("location: index.php");
}

?>