<?php

require_once('DB_Manager.php');

define('delimiter', ',');

//argv[0] es el nombre del programa
$fileName = $argv[1]; 
$file = fopen($fileName, 'r');
if(!$file){
	echo 'No se puede encontrar el archivo ' . $fileName . "\n";
	exit;
}
$skipFirstLine = true;
$db = new DBManager();
while( ($challengeInfo = fgetcsv($file)) ){
	if( $skipFirstLine ){
		$skipFirstLine = false;
		continue;
	}
	if( count($challengeInfo) != 4 ){
		echo 'Esta linea esta mal ' . $line . "\n";
		continue;
	}
	
	$challengeName = trim($challengeInfo[0]);
	$challengeDescription = trim($challengeInfo[1]);
	$challengeHashtag = trim($challengeInfo[2]);
	$challengeScore = (int)trim($challengeInfo[3]);
	
	echo $challengeName . "\n" . 
		$challengeDescription . "\n" . 
		$challengeHashtag . "\n" . 
		$challengeScore . "\n";

	$db->addNewChallenge($challengeName, $challengeDescription, $challengeHashtag, $challengeScore);
}
unset($db);

?>