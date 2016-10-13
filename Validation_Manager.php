<?php

require_once("Validation_Utility.php");
require_once("Error_Codes.php");
require_once("Status_Codes.php");

class ValidationManager{

	public static function validateFormRegisterUser(&$twitter_name, &$name, &$school, &$password, &$password_check){
		$twitter_name = ValidationUtility::sanitizeString($twitter_name);
		$name = ValidationUtility::sanitizeString($name);
		$school = ValidationUtility::sanitizeString($school);
		$password = ValidationUtility::sanitizeString($password);
		$password_check = ValidationUtility::sanitizeString($password_check);

		if( !ValidationUtility::isValidTwitterName($twitter_name) ){
			ValidationUtility::setErrorCode("U_twitterName");
			return false;
		}

		if( !ValidationUtility::isValidTwitterNameLength($twitter_name) ){
			ValidationUtility::setErrorCode("U_twitterNameLength");
			return false;
		}

		if( !ValidationUtility::isValidName($name) ){
			ValidationUtility::setErrorCode("U_name");
			return false;
		}

		if( !ValidationUtility::isValidNameLength($name) ){
			ValidationUtility::setErrorCode("U_nameLength");
			return false;
		}

		if( !ValidationUtility::isValidSchool($school) ){
			ValidationUtility::setErrorCode("U_school");
			return false;
		}

		if( !ValidationUtility::isValidSchoolLength($school) ){
			ValidationUtility::setErrorCode("U_schoolLength");
			return false;
		}

		if( !ValidationUtility::isValidPasswordLength($password) ){
			ValidationUtility::setErrorCode("U_passwordLength");
			return false;
		}

		if( !ValidationUtility::passwordsMatch($password, $password_check) ){
			ValidationUtility::setErrorCode("U_passwordNotMatch");
			return false;
		}
		$password = ValidationUtility::hashString($password);

		return true;
	}

}

?>