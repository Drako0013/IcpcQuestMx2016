<?php

require_once("DB_Manager.php");

if( isset($_GET['id']) and isset($_GET['result']) ){
	$id = (int)$_GET['id'];
	$result = $_GET['result'];

	if($result == 'yes'){
		$db = new DBManager();
		$db->acceptChallengeCompletion($id);
		header("location: View_UnvalidatedTweets.php");
	} else {
		if($result == 'no'){
			$db = new DBManager();
			$db->unacceptChallengeCompletion($id);
			header("location: View_UnvalidatedTweets.php");
		} else {
			header("location: View_UnvalidatedTweets.php");
		}
	}
} else {
	header("location: View_UnvalidatedTweets.php");
}
	
?>