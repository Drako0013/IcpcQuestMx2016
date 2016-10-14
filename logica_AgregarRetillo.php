<?php

require_once("DB_Manager.php");

if( isset($_POST["name"]) and isset($_POST["description"]) and isset($_POST["hashtag"]) and isset($_POST["score"]) ){
	$name  =$_POST["name"];
	$description = $_POST["description"];
	$hashtag = $_POST["hashtag"];
	$score = $_POST["score"];

	$db = new DBManager();
	$db->addNewChallenge($name, $description, $hashtag, $score);
	unset($db);

}
header("location: vistaChida_AgregarRetillo.php");
exit;

?>