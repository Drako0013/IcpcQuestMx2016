<?php

require_once("Validation_Utility.php");
require_once("Error_Codes.php");
require_once("Status_Codes.php");

class ValidationManager{

	public static function validateTwitterName(&$twitter_name){
		$twitter_name = ValidationUtility::sanitizeString($twitter_name);
		if( !ValidationUtility::isValidTwitterName($twitter_name) ){
			ValidationUtility::setErrorCode("U_twitterName");
			return false;
		}

		if( !ValidationUtility::isValidTwitterNameLength($twitter_name) ){
			ValidationUtility::setErrorCode("U_twitterNameLength");
			return false;
		}
		return true;
	}

	public static function validateContestantName(&$name){
		$name = ValidationUtility::sanitizeString($name);
		if( !ValidationUtility::isValidName($name) ){
			ValidationUtility::setErrorCode("U_name");
			return false;
		}

		if( !ValidationUtility::isValidNameLength($name) ){
			ValidationUtility::setErrorCode("U_nameLength");
			return false;
		}
		return true;
	}

	public static function validateSchool(&$school){
		$school = ValidationUtility::sanitizeString($school);
		if( !ValidationUtility::isValidSchool($school) ){
			ValidationUtility::setErrorCode("U_school");
			return false;
		}

		if( !ValidationUtility::isValidSchoolLength($school) ){
			ValidationUtility::setErrorCode("U_schoolLength");
			return false;
		}
		return true;
	}

	public static function validateMatchingPasswords(&$password, $password_check, $required = true){
		$password = ValidationUtility::sanitizeString($password);
		$password_check = ValidationUtility::sanitizeString($password_check);

		if( $required ){
			if( !ValidationUtility::isValidPasswordLength($password) ){
				ValidationUtility::setErrorCode("U_passwordLength");
				return false;
			}
		} else {
			if( !(ValidationUtility::isValidPasswordLength($password) or empty($password)) ){
				ValidationUtility::setErrorCode("U_passwordLength");
				return false;
			}
		}

		if( !ValidationUtility::passwordsMatch($password, $password_check) ){
			ValidationUtility::setErrorCode("U_passwordNotMatch");
			return false;
		}

		$password = ValidationUtility::hashString($password);
		return true;
	}

	public static function validateFormRegisterUser(&$twitter_name, &$name, &$school, &$password, &$password_check){
		if( !ValidationManager::validateTwitterName($twitter_name) ){
			return false;
		}

		if( !ValidationManager::validateContestantName($name) ){
			return false;
		}

		if( !ValidationManager::validateSchool($school) ){
			return false;
		}		

		if( !ValidationManager::validateMatchingPasswords($password, $password_check, $required = true) ){
			return false;
		}

		return true;
	}

	public static function validateFormEditUser(&$twitter_name, &$name, &$school, &$password, &$new_password, &$new_password_check){
		if( !ValidationManager::validateTwitterName($twitter_name) ){
			return false;
		}

		if( !ValidationManager::validateContestantName($name) ){
			return false;
		}

		if( !ValidationManager::validateSchool($school) ){
			return false;
		}
		
		if( !ValidationManager::validateMatchingPasswords($password, $password, $required = true) ){
			return false;
		}

		if( !ValidationManager::validateMatchingPasswords($new_password, $new_password_check, $required = false) ){
			return false;
		}

		return true;
	}

	public static function validateFormLogin(&$twitter_name, &$password){
		if( !ValidationManager::validateTwitterName($twitter_name) ){
			return false;
		}

		if( !ValidationManager::validateMatchingPasswords($password, $password, $required = true) ){
			return false;
		}

		return true;
	}

}

?>